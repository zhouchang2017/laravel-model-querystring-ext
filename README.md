# About This Packagist

## 使用说明

- 模型implements`QueryInterface`接口
- 模型引入Traits 实现`QueryInterface`接口


#### Post模型
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Zc\Query\Contracts\QueryInterface;
use Zc\Query\Traits\QueryTrait;

class Post extends Model implements Transformable,QueryInterface
{
    use TransformableTrait,QueryTrait;

    protected $fillable=['title','avatar','body','user_id','originate','read_num','fake_read_num','hidden','is_hot','deleted_at'];

    protected $fieldSearchable = [
        // 允许通过url字符串查询的字段
        'title','avatar','body','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    ...
}
```
#### PostsController
```
<?php

namespace App\Http\Controllers;

use App\Post;

class TestPostController extends Controller
{
    protected $post;

    /**
     * TestPostController constructor.
     * @param $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        return $this->post->apply()->get();
    }
}

```

search title eq 'consectetur' by request

> http://admin.test/test/posts?search=consectetur&searchFields=title:like

```
[
    {
        "id": 1,
        "title": "Sit consectetur omnis quo nemo velit suscipit voluptas.",
        "avatar": "https://lorempixel.com/640/480/?81554",
        "body": "<html><head><title>Nisi vel ut enim et voluptas.</title></head><body><form action=\"example.org\" method=\"POST\"><label for=\"username\">optio</label><input type=\"text\" id=\"username\"><label for=\"password\">alias</label><input type=\"password\" id=\"password\"></form><div class=\"impedit\"><div class=\"a\"><p>Veritatis optio vel.</p>Rerum ut id magnam deserunt nemo vel ullam commodi et ut.</div></div><div id=\"31996\"></div></body></html>\n",
        "user_id": 1,
        "originate": "Gleason-Mosciski",
        "read_num": 77461,
        "fake_read_num": 679233500,
        "hidden": 0,
        "is_hot": 0,
        "deleted_at": null,
        "created_at": "2018-04-03 15:37:01",
        "updated_at": "2018-04-03 15:37:01"
    },
    {
        "id": 14,
        "title": "Aut hic consequatur distinctio nihil et et consectetur.",
        "avatar": "https://lorempixel.com/640/480/?31241",
        "body": "<html><head><title>Et nihil minima sit est rerum et autem illo totam a repellendus sequi quasi.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">et</label><input type=\"text\" id=\"username\"><label for=\"password\">esse</label><input type=\"password\" id=\"password\"></form><div class=\"ipsam\"></div><div id=\"29792\"></div><div class=\"deleniti\"></div></body></html>\n",
        "user_id": 1,
        "originate": "Torp Inc",
        "read_num": 983,
        "fake_read_num": 33786,
        "hidden": 0,
        "is_hot": 0,
        "deleted_at": null,
        "created_at": "2018-04-03 15:37:01",
        "updated_at": "2018-04-03 15:37:01"
    },
    ...
]
```

> http://admin.test/test/posts?search=Gleason-Mosciski&searchFields=originate:=
```
[
    {
        "id": 1,
        "title": "Sit consectetur omnis quo nemo velit suscipit voluptas.",
        "avatar": "https://lorempixel.com/640/480/?81554",
        "body": "<html><head><title>Nisi vel ut enim et voluptas.</title></head><body><form action=\"example.org\" method=\"POST\"><label for=\"username\">optio</label><input type=\"text\" id=\"username\"><label for=\"password\">alias</label><input type=\"password\" id=\"password\"></form><div class=\"impedit\"><div class=\"a\"><p>Veritatis optio vel.</p>Rerum ut id magnam deserunt nemo vel ullam commodi et ut.</div></div><div id=\"31996\"></div></body></html>\n",
        "user_id": 1,
        "originate": "Gleason-Mosciski",
        "read_num": 77461,
        "fake_read_num": 679233500,
        "hidden": 0,
        "is_hot": 0,
        "deleted_at": null,
        "created_at": "2018-04-03 15:37:01",
        "updated_at": "2018-04-03 15:37:01"
    }
]
```

filter fields by request
> http://admin.test/test/posts?search=Gleason-Mosciski&searchFields=originate:=&filter=title;body;avatar
```
[
    {
        "title": "Sit consectetur omnis quo nemo velit suscipit voluptas.",
        "body": "<html><head><title>Nisi vel ut enim et voluptas.</title></head><body><form action=\"example.org\" method=\"POST\"><label for=\"username\">optio</label><input type=\"text\" id=\"username\"><label for=\"password\">alias</label><input type=\"password\" id=\"password\"></form><div class=\"impedit\"><div class=\"a\"><p>Veritatis optio vel.</p>Rerum ut id magnam deserunt nemo vel ullam commodi et ut.</div></div><div id=\"31996\"></div></body></html>\n",
        "avatar": "https://lorempixel.com/640/480/?81554"
    }
]
```
> http://admin.test/test/posts?filter=title;body;avatar
```
[
 - {
    title: "Sit consectetur omnis quo nemo velit suscipit voluptas.",
    body: "<html><head><title>Nisi vel ut enim et voluptas.</title></head><body><form action="example.org" method="POST"><label for="username">optio</label><input type="text" id="username"><label for="password">alias</label><input type="password" id="password"></form><div class="impedit"><div class="a"><p>Veritatis optio vel.</p>Rerum ut id magnam deserunt nemo vel ullam commodi et ut.</div></div><div id="31996"></div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?81554"
 },
 - {
    title: "Dolores quam doloribus nulla fugit rerum quod.",
    body: "<html><head><title>Ut modi at animi ex architecto autem natus dolor ratione sapiente qui consequatur.</title></head><body><form action="example.org" method="POST"><label for="username">maiores</label><input type="text" id="username"><label for="password">ut</label><input type="password" id="password"></form><div id="69961"><div class="laboriosam"></div><div id="8049"><h1>Nostrum vero excepturi doloremque libero.</h1><a href="example.com">Laborum voluptatem.</a>Aut eius dolores.<h2>Fuga.</h2></div></div><div class="error"></div><div class="sit"><span>Eos aut voluptate laudantium voluptatem rem odit dolorum dolor beatae nisi.</span>Vel inventore modi voluptatum aliquam tempore et.</div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?55147"
 },
 - {
    title: "Aliquid est libero asperiores quo magnam.",
    body: "<html><head><title>Consequatur exercitationem natus voluptatum dolor praesentium et laboriosam unde.</title></head><body><form action="example.org" method="POST"><label for="username">asperiores</label><input type="text" id="username"><label for="password">omnis</label><input type="password" id="password"></form><div id="85593"><i>Consequatur maxime qui distinctio veniam in.</i>Laudantium.<h2>Velit nesciunt maiores et ea aliquid velit temporibus.</h2></div><div id="69884"><i>Id aperiam provident autem fugiat.</i><table><thead><tr><th>Esse aut quidem consequuntur.</th><th>Sint doloremque.</th></tr></thead><tbody><tr><td>Facilis facere eaque.</td><td>In qui tenetur non.</td></tr></tbody></table><span>A cupiditate sed.</span></div><div class="et"></div><div id="54351"><ul><li>Minima aut ut voluptatem.</li><li>Eos cumque soluta.</li><li>Sit et temporibus sapiente.</li><li>Omnis aliquam.</li><li>Asperiores error numquam.</li><li>Aut iste ab iusto.</li><li>Quidem soluta.</li><li>Commodi dolores sed at ab velit.</li><li>Omnis ipsam.</li><li>Voluptas libero minima eveniet odio.</li><li>Sed ut eos.</li></ul></div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?47981"
 },
 ...
 ]
```
Sorting the results
> http://admin.test/test/posts?filter=title;body;avatar;id;read_num&order=read_num&sort=desc
```
[
 - {
    title: "Sunt quibusdam excepturi officia sunt et perferendis.",
    body: "<html><head><title>Est illo architecto fugiat id in facere.</title></head><body><form action="example.com" method="POST"><label for="username">qui</label><input type="text" id="username"><label for="password">ullam</label><input type="password" id="password"></form><div id="55383"><div id="93207"></div></div><div class="amet"><div id="60973"><ul><li>Aut quia nisi.</li></ul><p>Quibusdam occaecati omnis iusto aut magnam voluptatem accusamus quae.</p>Eligendi quis.</div><div id="7240"><p>Cupiditate dolorem dolorum sed deleniti.</p></div><div id="76416"></div></div><div id="35827"><div class="ipsam"><p>Corrupti reiciendis doloremque qui nobis quis et nihil.</p></div></div><div class="ut"></div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?44230",
    id: 837,
    read_num: 978416734
 },
 - {
    title: "Ea dolores rem cumque illum ducimus.",
    body: "<html><head><title>Error et impedit non qui tempora quis.</title></head><body><form action="example.net" method="POST"><label for="username">alias</label><input type="text" id="username"><label for="password">labore</label><input type="password" id="password"></form><div class="excepturi"><div id="1654">Numquam porro voluptatem.<p>Officia sapiente accusamus quo non ut adipisci quisquam quia.</p><i>Unde suscipit praesentium aut amet sint sit doloribus velit sint.</i></div><div class="ratione"></div></div><div id="85502"></div><div id="2632"><div id="69036"></div><div id="55806"><p>Dolorem quia.</p><a href="example.net">Eum sed.</a></div></div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?66807",
    id: 334,
    read_num: 971639102
 },
 - {
    title: "Voluptas error quod facere atque rerum similique cum.",
    body: "<html><head><title>Et dignissimos.</title></head><body><form action="example.net" method="POST"><label for="username">quia</label><input type="text" id="username"><label for="password">et</label><input type="password" id="password"></form><div class="repellat"></div><div class="repellat"></div><div class="debitis"></div><div id="73446"></div></body></html>
    ",
    avatar: "https://lorempixel.com/640/480/?75544",
    id: 34,
    read_num: 954129092
 },
 ...
]
```
Add relationship
> http://admin.test/test/posts?filter=title;user_id;avatar;id&with=user
```
 [
 - {
    title: "Sit consectetur omnis quo nemo velit suscipit voluptas.",
    user_id: 1,
    avatar: "https://lorempixel.com/640/480/?81554",
    id: 1,
    user: - {
            id: 1,
            name: "zhouchang",
            email: "290621352@qq.com",
            created_at: "2018-04-03 15:43:56",
            updated_at: "2018-04-03 15:43:56"
        }
     },
     - {
    title: "Dolores quam doloribus nulla fugit rerum quod.",
    user_id: 1,
    avatar: "https://lorempixel.com/640/480/?55147",
    id: 2,
    user: - {
        id: 1,
        name: "zhouchang",
        email: "290621352@qq.com",
        created_at: "2018-04-03 15:43:56",
        updated_at: "2018-04-03 15:43:56"
    }
 },
 ...
 ]
```


> 从`andersao/l5-repository`抽离出来的RequestQueryCriteria功能
