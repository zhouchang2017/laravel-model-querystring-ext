# About This Packagist

## 使用说明

- 模型implements`QueryInterface`接口
- 模型引入Traits 实现`QueryInterface`接口
```

<?php

namespace App;

...
use Zc\Query\Contracts\QueryInterface
use Zc\Query\Traits\QueryTrait
use Illuminate\Foundation\Auth\User as Authenticatable;
...


class User extends Authenticatable implements QueryInterface
{
    use QueryTrait;
    
    protected $fieldSearchable = [
        // 允许通过url字符串查询的字段
    ];
}

PostsController

class UsersController extends Controller
{
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function index(Request $request)
    {
        return $this->user->all();
    }
}
```

Request all data without filter by request

> http://localhost/users

```
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum",
        "email": "lorem@ipsum.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 3,
        "name": "Laravel",
        "email": "laravel@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    }
]
```
  





> 从`andersao/l5-repository`抽离出来的RequestQueryCriteria功能
