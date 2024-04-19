# damoang


## Docker로 빠르게 시작하기
압축을 폴고 폴더로 이동해서 docker-compose 명령어를 실행합니다. 

```
$ cd gnuboard_nariya_폴더
$ ls
$ apps  damoang_src  docker-compose.yml  mysql_data
$ docker-compose up -d
```

## 그누보드 설치 
http://localhost 로 접속한 후 그누보드를 설치합니다. 
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

## theme > basic 폴더 변경
기존에 있던 basic 대신 git에서 받은 damoang theme을 basic을 사용합니다.
(없다면 theme폴더에 basic폴더를 만들고 damoang theme폴더 파일들을 복사합니다)
 

## '짝짝짝 ' 설치완료   
http://localhost 에 접속하면 다모앙 사이트가 보입니다.  
(알림: 실소스와 CSS, DB와 차이가 있어 군데군데 오류가 있습니다, 구조파악용으로 먼저 보세요)
