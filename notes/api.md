

## GET COMMUNITIES INDEX: 

GET  /api/community/    NO AUTH

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

GET /api/community/{id}   NO AUTH

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