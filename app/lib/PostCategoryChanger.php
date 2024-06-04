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
        if ($this->canChangeCategory($targetWrId)) {
            $this->addCategoryMoveComment($targetCategory);
        }

        $this->updateCategory($targetWrId, $targetCategory);
    }

    private function canChangeCategory(string $targetWrId): bool
    {
        global $is_admin, $member, $view, $boset;

        // 대상 게시물 ID가 현재 게시물 ID와 일치하는지 확인
        if ($targetWrId !== $view['wr_id']) {
            return false;
        }

        // 설정에서 카테고리 이동이 허용되는지 확인
        if (!$boset['check_category_move']) {
            return false;
        }

        // 관리자만 카테고리 이동이 가능하고 사용자가 관리자일 경우
        if ($boset['category_move_permit'] === "admin_only" && $is_admin === "super") {
            return true;
        }

        // 관리자와 회원 모두 카테고리 이동이 가능한 경우
        if ($boset['category_move_permit'] === "admin_and_member") {
            // 관리자이거나 게시물 작성자일 경우
            if ($is_admin === "super" || $member['mb_id'] === $view['mb_id']) {
                return true;
            }
        }

        return false;
    }

    private function updateCategory(string $targetWrId, string $targetCategory): void
    {
        global $g5, $board, $view;

        $tableName = $g5['write_prefix'] . $board['bo_table'];
        $commentCnt = intval($view['wr_comment']) + 1; // 댓글 개수 1 증가
        $targetCategoryEscaped = sql_real_escape_string($targetCategory);
        $wrId = (int)$view['wr_id'];

        $sql = <<<SQL
            UPDATE $tableName
            SET ca_name = '$targetCategoryEscaped',
                wr_comment = $commentCnt
            WHERE wr_id = $wrId
        SQL;

        sql_query($sql);
    }

    // 카테고리 변경 댓글 삽입
    private function addCategoryMoveComment(string $targetCategory): void
    {
        global $g5, $board, $member, $view, $boset;

        $variables = [
            'auth_member' => $member['mb_name'],
            'src_cat' => $view['ca_name'],
            'dest_cat' => $targetCategory
        ];
        $commentMessage = $this->completeMessage($boset['category_move_message'], $variables);

        $tableName = $g5['write_prefix'] . $board['bo_table'];
        $targetCategory = sql_real_escape_string($targetCategory);
        $postNumber = (int)$view['wr_num'];
        $parentPostId = (int)$view['wr_id'];
        $commentMessage = sql_real_escape_string($commentMessage);
        $memberId = sql_real_escape_string($member['mb_id']);
        $memberName = sql_real_escape_string($member['mb_name']);
        $memberEmail = sql_real_escape_string($member['mb_email']);
        $memberHomepage = sql_real_escape_string($member['mb_homepage']);
        $currentDatetime = G5_TIME_YMDHIS;
        $ipAddress = sql_real_escape_string($_SERVER['REMOTE_ADDR']);

        $sql = <<<SQL
            INSERT INTO $tableName
            SET ca_name = '$targetCategory',
                wr_num = $postNumber,
                wr_parent = $parentPostId,
                wr_is_comment = 1,
                wr_comment = 1,
                wr_content = '$commentMessage',
                mb_id = '$memberId',
                wr_name = '$memberName',
                wr_email = '$memberEmail',
                wr_homepage = '$memberHomepage',
                wr_datetime = '$currentDatetime',
                wr_ip = '$ipAddress'
        SQL;

        sql_query($sql);
    }

    private function validateMessageFormat(string $messageFormat): void
    {
        $allowedVariables = ['auth_member', 'src_cat', 'dest_cat'];
        $doubleBracePattern = '/{{(.*?)}}/';
        $invalidVariables = [];

        $filteredMessage = preg_replace_callback($doubleBracePattern, function ($matches) use ($allowedVariables, &$invalidVariables) {
            if (!in_array($matches[1], $allowedVariables)) {
                $invalidVariables[] = $matches[0];
                return '';
            }
            return '';
        }, $messageFormat);

        if (!empty($invalidVariables)) {
            throw new Exception('메세지 형식에 올바르지 않은 변수가 사용되었습니다: ' . implode(', ', $invalidVariables));
        }

        if (preg_match('/[{}]/', $filteredMessage)) {
            throw new Exception('올바른 메세지 형식이 아닙니다.');
        }
    }


    private function completeMessage(string $messageFormat, array $variables): string
    {
        try {
            $this->validateMessageFormat($messageFormat);
        } catch (Exception $e) {
            throw new Exception("메세지 포맷 검증 실패: " . $e->getMessage());
        }

        return preg_replace_callback('/{{([^}]+)}}/', function ($matches) use ($variables) {
            $variable = $matches[1];
            return $variables[$variable] ?? 'undefined';
        }, $messageFormat);
    }
}
