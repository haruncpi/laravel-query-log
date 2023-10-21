<h1 align="center">Laravel Query Log</h1>
<p align="center">
    <a href="https://packagist.org/packages/haruncpi/laravel-query-log"><img src="https://badgen.net/packagist/v/haruncpi/laravel-query-log" /></a>
    <a href="https://creativecommons.org/licenses/by/4.0/"><img src="https://badgen.net/badge/licence/CC BY 4.0/23BCCB" /></a>
     <a href=""><img src="https://badgen.net/packagist/dt/haruncpi/laravel-query-log"/></a>
    <a href="https://twitter.com/laravelarticle"><img src="https://badgen.net/badge/twitter/@laravelarticle/1DA1F2?icon&label" /></a>
    <a href="https://facebook.com/laravelarticle"><img src="https://badgen.net/badge/facebook/laravelarticle/3b5998"/></a>
</p>
<p align="center">Log executed Laravel SQL queries and their line number and more!</p>


## Support
<a href="https://www.buymeacoffee.com/haruncpi" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" style="width: 160px !important;" ></a>

## Documentation
Get documentation on [laravelarticle.com](https://laravelarticle.com/laravel-query-log)

## Sample Preview
text format
```text
url         : http://example.test
method      : GET
total_query : 3
total_time  : 5.69
--------------------

sl          : 1
query       : select * from `students` where `id` = ? and `name` = ?
bindings    : 6|Tomas
final_query : select * from `students` where `id` = 6 and `name` = 'Tomas'
time        : 4.38
file        : C:\www\example\app\Http\Controllers\SiteController.php:10
line        : 10

sl          : 2
query       : select * from `students` where `id` = ? and `phone` = ?
bindings    : 6|649-768-7305
final_query : select * from `students` where `id` = 6 and `phone` = '649-768-7305'
time        : 0.75
file        : C:\www\example\app\Http\Controllers\SiteController.php:11
line        : 11

sl          : 3
query       : select * from `students` where `id` = ?
bindings    : 6
final_query : select * from `students` where `id` = 6
time        : 0.56
file        : C:\www\example\app\Http\Controllers\SiteController.php:12
line        : 12
```

## Other Packages
- [Laravel Log Reader](https://github.com/haruncpi/laravel-log-reader) - A simple and beautiful laravel log reader.
- [Laravel H](https://github.com/haruncpi/laravel-h) - A helper package for Laravel Framework.
- [Laravel Simple Filemanager](https://github.com/haruncpi/laravel-simple-filemanager) - A simple filemanager for Laravel.
- [Laravel Option Framework](https://github.com/haruncpi/laravel-option-framework) - Option framework for Laravel.
