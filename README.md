Collections
===========

**Collections** for php, inspired by OOP generic languages structures

[![Build Status](https://travis-ci.org/Sharkzt/Collections.svg?branch=master)](https://travis-ci.org/Sharkzt/Collections)
[![Coverage Status](https://coveralls.io/repos/github/Sharkzt/Collections/badge.svg)](https://coveralls.io/github/Sharkzt/Collections)

Installation
------------

The recommended way to install bundle is through
[Composer](http://getcomposer.org/):

```bash
$ composer require sharkzt/collections
```


Usage Examples
--------------

### ArrayList

``` php
//rough example of ArrayListcreation, usually goes in constructor; see examples classes
$user = new User();
$user->articles = new ArrayList(Article::class);  
```

ArrayList will accept only Article instances as arguments. 

``` php
//addAll argument can be any iterable form, like ArrayList
$user->articles->addAll([
    (new Article())
        ->setTitle('foo')
        ->setContent('bar'), 
    (new Article())
        ->setTitle('baz')
        ->setContent('qux'),
]);

$singleArticle = (new Article())
    ->setTitle('foo')
    ->setContent('bar');
$user->articles->add($singleArticle);
```

Can add iterable articles, or single invoking add method.

``` php
if ($user->articles->contains($singleArticle)) {
    $user->articles->remove($singleArticle);    
}

foreach ($user->articles as $article) {
    if ($article->getContent() === 'qux') {
        $article->setTitle('foo');
        break;
    }
}
``` 

Possible usage examples.

License
-------

Collections classes are released under the MIT License. See the bundled LICENSE file for
details.

