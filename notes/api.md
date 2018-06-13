

## GET COMMUNITIES INDEX: 

GET  /api/community/    

NO AUTH

test response:

```
{
    "status_code": 666,
    "communities": [
        {
            "id": 2,
            "name": "COM_1",
            "brief": "test XXX",
            "created_at": "2018-06-12 08:04:35",
            "updated_at": "2018-06-12 08:04:35",
            "icon": "http://clubook.club/images/1528790675.jpg"
        },
        {
            "id": 3,
            "name": "COM_2",
            "brief": "test 222",
            "created_at": "2018-06-12 08:05:00",
            "updated_at": "2018-06-12 08:05:00",
            "icon": "http://clubook.club/images/1528790700.jpg"
        },
        {
            "id": 4,
            "name": "COM_3",
            "brief": "test 3333",
            "created_at": "2018-06-12 08:05:27",
            "updated_at": "2018-06-12 08:05:27",
            "icon": "http://clubook.club/images/1528790727.jpg"
        }
    ]
}
```

## GET COMMUNITY

GET /api/community/{id}   

NO AUTH

test response:

```
{
    "status_code": 666,
    "community": {
        "id": 2,
        "name": "COM_1",
        "brief": "test XXX",
        "created_at": "2018-06-12 08:04:35",
        "updated_at": "2018-06-12 08:04:35",
        "icon": "http://clubook.club/images/1528790675.jpg"
    }
}
```

if community doesn't exist:

```
{
    "status_code": 666,
    "community": null
}
```


## CREATE COMMUNITY :

创建和上传图片分两个request进行。
AUTH HEADER REQUIRED
/api/community/create
JSON DATA:

```
{
    "name" : "example" ,
    "brief" : "example" ,

}
```

response 会返回成功创建的新社团id，这个id是社团的唯一标识，用于后续上传图片 


```
{
    "status_code": 666,
    "id": 7,
    "message": "success"
}
```


图片上传 ： 要求当前用户是社团的创建者或管理员
/api/community/icon

```
form data:

    "id" : xxx ,
    "image" : [multi-form data file]


```
response:

```
{
    "status_code": 666,
    "id": "1",
    "message": "success"
}
```


如果没有权限：
```
{
    "status_code": 502,
    "message": "you are not allowed to do that"
}
```

## CIRCLE
和community操作一样，所有api前缀改成
/api/circle 


## CHANGE USER ICON

/api/user/change_icon


## ARTICLE
/api/article/create
TOKEN REQUIRED

POST JSON

```
{
    "title": "title",
    "body": "content",
    "to": [
        {
            "type": "community",
            "id": 1
        },
        {
            "type": "circle",
            "id": 1
        }
    ]
}

```

成功则返回666 success
务必注意，要确定发文章的人拥有对应圈子/社团的权限   （非社团圈子成员不能在里面发文章）
服务端暂时没有进一步验证用户权限。


## 点赞： /api/article/like/{id}

token required...

## 获取文章列表
全部文章列表：

api/article/index

社团的文章

api/article/community/{id}

圈子的文章

api/article/circle/{id}

## MY CIRCLE/ COMMUNITY:
/api/user/mygroups

json data

```
{
    "status_code": 666,
    "communities": [
        {
            "id": 9,
            "name": "COM_n",
            "brief": "c test",
            "created_at": "2018-06-12 17:05:23",
            "updated_at": "2018-06-12 17:05:23",
            "my role": "creator"
        },
        {
            "id": 10,
            "name": "COM_x",
            "brief": "fff test",
            "created_at": "2018-06-12 17:08:10",
            "updated_at": "2018-06-12 17:08:10",
            "my role": "creator"
        }
    ],
    "circles": [
        {
            "id": 1,
            "name": "circleX",
            "brief": "simple test",
            "created_at": "2018-06-12 15:53:25",
            "updated_at": "2018-06-12 15:53:25",
            "my role": "creator"
        },
        {
            "id": 2,
            "name": "circleX2",
            "brief": "simple test",
            "created_at": "2018-06-12 15:53:55",
            "updated_at": "2018-06-12 15:53:55",
            "my role": "creator"
        }
    ]
}
```


## JOIN COMMUNITY / CIRCLE

TOKEN REQUIRED 

- GET /api/community/join/{id}

- GET /api/circle/join/{id}

## COMMENTS

GET COMMENTS:

GET  /api/article/{article_id}/comments

NO TOKEN


CREATE ARTICLE COMMENTS:

POST WITH TOKEN:

/api/article/comment

json body:

```
{
"article_id" : "1",
"body" : "fff test"
}
```

response :

```
{
    "status_code": 666,
    "comments": [
        {
            "id": 1,
            "title": "NA",
            "body": "testxxxx",
            "likes": 0,
            "author_id": 1,
            "object_type": "article",
            "object_id": 1,
            "created_at": "2018-06-13 14:06:43",
            "updated_at": "2018-06-13 14:06:43",
            "name": "test",
            "user_icon": "http://xmyapi.io/images/1528896263.jpg"
        },
        {
            "id": 2,
            "title": "NA",
            "body": "fff test",
            "likes": 0,
            "author_id": 1,
            "object_type": "article",
            "object_id": 1,
            "created_at": "2018-06-13 14:28:00",
            "updated_at": "2018-06-13 14:28:00",
            "name": "test",
            "user_icon": "http://xmyapi.io/images/1528896263.jpg"
        },
        {
            "id": 3,
            "title": "NA",
            "body": "fff test",
            "likes": 0,
            "author_id": 1,
            "object_type": "article",
            "object_id": 1,
            "created_at": "2018-06-13 14:28:01",
            "updated_at": "2018-06-13 14:28:01",
            "name": "test",
            "user_icon": "http://xmyapi.io/images/1528896263.jpg"
        },
        {
            "id": 4 ....
            .....
            .....
```


## 返回文章详情（带评论）

GET /api/article/{id}

NO TOKEN

response

```
{
    "status_code": 666,
    "article": {
        "id": 1,
        "title": "title",
        "body": "content",
        "author_id": 2,
        "type": "normal",
        "likes": 8,
        "created_at": "2018-06-12 18:46:32",
        "updated_at": "2018-06-12 18:46:32"
    },
    "comments": [
        {
            "id": 1,
            "title": "NA",
            "body": "testxxxx",
            "likes": 0,
            "author_id": 1,
            "object_type": "article",
            "object_id": 1,
            "created_at": "2018-06-13 14:06:43",
            "updated_at": "2018-06-13 14:06:43",
            "name": "test",
            "user_icon": "http://xmyapi.io/images/1528896263.jpg"
        },
        {
            "id": 2,
            "title": "NA",
            "body
```