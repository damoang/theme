<?php
declare(strict_types=1);

/**
 * 글 하나의 카테고리 변경만 고려하고 작성
 * 관리자가 리스트에서 한번에 여러 카테고리 변경에 사용할 수 있도록 개선 예정
 */
class PostCategoryChanger
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function changeCategory(string $targetWrId, string $targetCategory): void
    {
        global $g5, $is_admin, $member, $board, $view, $boset;
        $db = $g5['connect_db'];

        if ($targetWrId == $view['wr_id'] &&
            ($boset['check_category_move'] && in_array($boset['category_move_permit'], ["admin_only", "admin_and_member"]) && $is_admin == "super") ||
            ($boset['check_category_move'] && $boset['category_move_permit'] == "admin_and_member" && $member['mb_id'] == $view['mb_id'])) {
            $this->addCategoryMoveComment();
        }

        // 카테고리 변경
        $tableName = $g5['write_prefix'] . $board['bo_table'];
        $commentCnt = intval($view['wr_comment']) + 1; // 댓글 개수 1 증가
        $sql = "UPDATE $tableName
                    SET ca_name = '" . sql_real_escape_string($targetCategory) . "',
                        wr_comment = $commentCnt
                    WHERE wr_id = " . (int)$view['wr_id'];

        sql_query($sql);

    }

    // 카테고리 변경 댓글 삽입
    private function addCategoryMoveComment(): void
    {
        global $g5, $board, $member, $view, $targetCategory, $boset;

        $variables = [
            'auth_member' => $member['mb_name'],
            'src_cat' => $view['ca_name'],
            'dest_cat' => $targetCategory
        ];
        $commentMessage = $this->completeMessage($boset['category_move_message'], $variables);

        $tableName = $g5['write_prefix'] . $board['bo_table'];
        $sql = "INSERT INTO $tableName
                    SET ca_name = '" . sql_real_escape_string($targetCategory) . "',
                        wr_num = " . (int)$view['wr_num'] . ",
                        wr_parent = " . (int)$view['wr_id'] . ",
                        wr_is_comment = 1,
                        wr_comment = 1,
                        wr_content = '" . sql_real_escape_string($commentMessage) . "',
                        mb_id = '" . sql_real_escape_string($member['mb_id']) . "',
                        wr_name = '" . sql_real_escape_string($member['mb_name']) . "',
                        wr_email = '" . sql_real_escape_string($member['mb_email']) . "',
                        wr_homepage = '" . sql_real_escape_string($member['mb_homepage']) . "',
                        wr_datetime = '" . G5_TIME_YMDHIS . "',
                        wr_ip = '" . sql_real_escape_string($_SERVER['REMOTE_ADDR']) . "'";

        $result = sql_query($sql);
    }

    private function completeMessage(string $messageFormat, array $variables): string
    {
        $allowedVariables = ['auth_member', 'src_cat', 'dest_cat'];
        $bracePattern = '/{{([^}]+)}}|{([^}]+)}/';

        // 중괄호 짝 검사
        $stack = [];
        $hasUnmatchedBraces = false;
        $braceErrors = [];
        $invalidVariables = [];

        for ($i = 0; $i < strlen($messageFormat); $i++) {
            if ($messageFormat[$i] === '{') {
                array_push($stack, '{');
            } elseif ($messageFormat[$i] === '}') {
                if (count($stack) === 0) {
                    $hasUnmatchedBraces = true;
                    break;
                }
                array_pop($stack);
            }
        }

        if (count($stack) > 0) {
            $hasUnmatchedBraces = true;
        }

        if ($hasUnmatchedBraces) {
            throw new Exception('중괄호({, })의 짝이 맞지 않습니다.');
        }

        $callback = function ($matches) use ($allowedVariables, $variables, &$invalidVariables, &$braceErrors) {
            $variable = isset($matches[1]) ? $matches[1] : $matches[2];
            $isDoubleBraced = isset($matches[1]);

            if (!$isDoubleBraced) {
                $braceErrors[] = "잘못된 중괄호 사용: {$matches[0]}";
                return $matches[0];
            } elseif (!in_array($variable, $allowedVariables)) {
                $invalidVariables[] = $matches[0];
                return $matches[0];
            } else {
                return isset($variables[$variable]) ? $variables[$variable] : $matches[0];
            }
        };

        $resultMessage = preg_replace_callback($bracePattern, $callback, $messageFormat);

        if (!empty($invalidVariables) || !empty($braceErrors)) {
            $errorMessage = '';
            if (!empty($invalidVariables)) {
                $errorMessage .= '메세지 형식에 올바르지 않은 변수가 사용되었습니다.\n\n';
                $errorMessage .= '허용된 변수: ' . implode(', ', $allowedVariables) . '\n\n';
                $errorMessage .= '잘못된 변수: ' . implode(', ', $invalidVariables) . '\n\n';
            }
            if (!empty($braceErrors)) {
                $errorMessage .= implode('\n', $braceErrors) . '\n';
            }
            throw new Exception($errorMessage);
        }

        return $resultMessage;
    }
}
