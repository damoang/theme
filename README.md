# Damoang


## ◽ 로컬 개발환경 Docker 컨테이너
도커 레파지토리 https://github.com/damoang/docker

로컬 컴퓨터에 폴더를 하나 만들고 그곳에 도커 레파지토리를 다운로드 받아 압축을 풀면 `docker-main` 폴더가 나옵니다. CLI(터미널,cmd)에서 이 폴더로 이동해서 `docker-compose` 명령어를 실행합니다.   

```
$ cd /경로/docker-main
$ docker-compose up -d
```
완료되면 다음 이미지로 이루어진 도커 컨테이너가 실행됩니다. 

확인 명령어: $`docker ps`
 * Nginx (80번포트)
 * php
 * mysql 
 
 또한 `docker-main` 과 같은 루트에 `www` 폴더가 생성됩니다. 이 폴더가 NginX 80포트가 가리키는 Web Document root 입니다. 이곳에 그누보드 코어 파일들을 넣어야합니다.

 > 컨테이너의 mysql 데이터베이스에는 gnuboard db만 있을뿐 비어있습니다. 


## ◽ 그누보드 코어 
### 그누보드 코어 다운로드 
안정(stable) 버전인 5.5.16 다운로드 (예:gnuboard5.5.16.tar.gz) https://sir.kr/g5_pds/7170

압축을 플어 나오는 폴더의 모든 내용물을  `www` 폴더에 넣습니다. 이제 이폴더는 그누보드 루트입니다.

### data 폴더 생성
`www` 폴더에 `data` 폴더를 생성하고 폴더권한을 777로 설정해줍니다 (컴퓨터사용자계정 누구나 읽기/실행/쓰기).
~~~
$ cd /경로/www
$ chmod 777 /경로/www/data
~~~


### 그누보드 코어 설치
http://localhost 로 접속한 후 안내에따라 그누보드를 설치합니다.  
DB 설정정보에서 Mysql부분은 아래 정보대로 입력하고  
최고관리자 정보는 사용자가 입력합니다  

* 그누보드 DB 설정 정보
```
<Mysql 정보입력>

Host : mysql
User : user 
Password : 1234
DB : gnuboard

<최고관리자 정보입력>
회원ID : <사용자 입력>
비밀번호 : <사용자 입력>
이름 : <사용자 입력>
E-mail : <사용자 입력>
```
그누보드가 성공적으로 설치되면 도커 NginX가 가리키는 80번 포트인 `http://localhost` 에 접속하여 그누보드 코어 기본 테마의 모습을 볼 수 있습니다.

## ◽ 나리야 테마 설치
나리야 테마 설치파일 https://amina.co.kr/nariya/notice/신-나리야-테스트-버전/

Nariya-0.1.zip 파일 압축을 풀고 해당 폴더를 www 폴더에 '덮어쓰기(overwrite,병합)' 합니다. 주의: replace(대치) 아님.

### 관리자 페이지 접속
홈페이지에서 로그인 한 후 빨간색 톱니바퀴를 클릭하여 접속

### 나리야 테마 사용
[관리자페이지 - 환경설정 - 테마설정] 에서 Nariya-Marigold 0.1a 선택
[관리자페이지 - 나리야 빌더 - 나리야 설정] 에서 '나리야 설치하기' 클릭해서 적용

## ◽ 다모앙 theme 레파지토리 클론

### - git clone
다운로드 폴더로 CLI(터미널)로 이동후 다음 명령어로 이 레파지토리를 로컬컴퓨터로 클론합니다.
~~~
$ cd /다운로드폴더경로
$ git clone git@github.com:damoang/theme.git`
~~~

그러면 theme 폴더가 생기고 하위에 다모앙 테마 레파지토리를 볼 수 있습니다. 이 안의 모든 파일을 옮겨야합니다.

### - fork 후 클론
fork 버전으로 관리하려면 먼저 이 레파지토리를 자신의 계정으로 fork 한 뒤 위와 같은 과정으로 로컬컴퓨터에 자신의 fork버전을 클론합니다. fork 버전을 최신으로 하려면 깃허브에서 `Sync fork` 한 뒤 로컬 레파지토리로 PULL 합니다.

### ◽ 그누에 적용
기존에 있던 www/theme/basic 안의 내용물 대신 git에서 받은 damoang theme을 basic에 복사해야합니다.

깃 클론으로 다운로드 받은 theme 폴더의 이름을 basic으로 바꾸고 그누보드가 설치된 www/theme 폴더로 이동/복사 시켜서 '바꿔치기(Replace)' 합니다. 주의: overwrite(덮어쓰기,병합) 아님


## ◽ '짝짝짝 ' 설치완료   
http://localhost 에 접속하면 다모앙과 같은 모습의 로컬 사이트가 보입니다.  
(알림: 실소스와 CSS, DB와 차이가 있어 군데군데 오류가 있습니다, 구조파악용으로 먼저 보세요)  

### 로컬 개발환경에서 로그인
`/bbs/login.php` 으로 접속하면 그누보드 설치당시 아이디/비번으로 로그인할 수 있습니다. 이러한 코어파일은 다모앙 them 레파지토리로 관리하는 부분이 아니므로 SNS로그인만 있는 실제 다모앙 사이트와는 다릅니다.

## ◽ git 브랜치 생성
www/theme/basic 폴더를 VS Code등 코드에디터 혹은 소스트리,fork등으로 열어보면 git gragh에서 브랜치 커밋이력을 볼 수 있습니다.

자신의 브랜치를 만들고 체크아웃합니다. CLI에서는 다음과 같이 입력하면 됩니다.
~~~
$ cd /폴더경로/www/theme/basic
$ git checkout -b 브랜치이름
~~~

## 코드작성
소스를 변경하면 로컬사이트에 반영됩니다.
안된다면 docker를 재시작 합니다.   
~~~
$ docker-compose down
$ docker-compose up -d
~~~

그누보드 플러그인은 본 레파지토리로 관리되지 않으므로 별도 협의 바랍니다.


---
<div align="center">

**🌍 다함께 모여 더욱 자유로운 세상, 다모앙. 🌍**

[![다모앙](https://damoang.net/data/editor/e78d4-66186ae0f41da-a579e74862c224c711dc921378a296e4599f957e.jpg)](https://damoang.net)


</div>