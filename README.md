EzQueryBuilder is a thin, simple fluent interface to the eZ Publish 5 Public API.

Its goal is to reduce the amount of code required to execute simple queries and to help you write readable, maintainable code.

The EzQueryBuilder class contains methods representing all of the built-in search criteria provided with the ezpublish-kernel. Each method contains appropriate documentation and type hints to help you write your query. The builder doesn't really do anything besides create the underlying query-related classes, but it saves you a few lines of code, and those can really add up on complex queries.

When your query is constructed, you can retrieve it for use from the $query property on the object.

```php
use Blend\Bundle\EzQueryBuilderBundle\Service\EzQueryBuilder as QueryBuilder

//...

$qb = new QueryBuilder();
$qb = $qb
        ->contentTypeIdentifier('blog_post')
        ->subtree($root->pathString)
        ->sortClause(new SortClause\Field('blog_post','publication_date', Query::SORT_DESC))
        ->limit($limit)
        ->offset($offset);
$postResults = $this->getRepository()->getSearchService()->findContent($qb->query);
```

If you want to use a custom query component, like your own criterion, there are base methods provided to add your own classes:

```php
$qb = new QueryBuilder();
$qb = $qb
        ->contentTypeIdentifier('article')
        ->criterion( new MyFunkyCriterion('http://weather.com','Rain') )
        ->limit(10);
$articlesFromPlacesItsRaining = $this->getRepository()->getSearchService()->findContent($qb->query);
```

This thing is super, super, early, and not ready for use as anything but discussion.
There's a forum thread where the concept is being discussed here:
http://share.ez.no/forums/ez-publish-5-platform/semantics-vs-pragmatism-in-ez-publish-5
