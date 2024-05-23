#!/bin/bash

# 스크립트를 실행하는 디렉토리로 이동합니다.
cd "$(dirname "$0")"

# 현재 디렉토리와 하위 디렉토리에 있는 모든 빈 폴더에 .gitkeep 파일을 생성합니다.
find . -type d -empty | while read dir; do
  touch "$dir/.gitkeep"
done

## .gitkeep 파일을 생성한 후에는 git add 명령어로 파일을 추가하고 커밋합니다.
#git add .
#git commit -m "Add .gitkeep to empty directories"
#
## git push 명령어로 원격 저장소에 푸시합니다.
