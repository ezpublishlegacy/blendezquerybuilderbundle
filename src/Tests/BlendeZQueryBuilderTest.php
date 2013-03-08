<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joe
 * Date: 3/8/13
 * Time: 5:28 AM
 * To change this template use File | Settings | File Templates.
 */
use Blend\EzQueryBuilderBundle\Services\BlendEzQueryBuilder as QueryBuilder,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalOr,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalNot,
    eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;

class BlendeZQueryBuilderTest extends PHPUnit_Framework_TestCase
{


    protected function checkCriteria($query, $class, $value, $type)
    {
        $criteria = reset($query->criterion->criteria);

        $this->assertInstanceOf($class, $criteria);

        if(is_array($value)) {
            $this->assertEquals($value, $criteria->value);
            $this->assertContainsOnly($type, $criteria->value);
        } else {
            $this->assertEquals($value, reset($criteria->value));
            $this->assertInternalType($type, reset($criteria->value));
        }
    }

    public function testLogicalAnd()
    {
        $qb = new QueryBuilder();

        $this->assertEquals(
            'eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd',
            get_class($qb->query->criterion)
        );

        $this->assertContainsOnlyInstancesOf(
            'eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface',
            $qb->query->criterion->criteria
        );
    }

    /**
     * @depends testLogicalAnd
     */
    public function testContentId()
    {
        $qb = new QueryBuilder();
        $q = $qb->contentId(5)->query;


        $this->checkCriteria(
            $q,
            'eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentId',
            5,
            'int'
        );

        $qb = new QueryBuilder();
        $q = $qb->contentId(array(5,3,7,9))->query;

        $this->checkCriteria(
            $q,
            'eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentId',
            array(5,3,7,9),
            'int'
        );


    }

    public function testContentTypeGroupId()
    {
        $qb = new QueryBuilder();
        $q = $qb->contentTypeGroupId(7)->query;

        $criteria = reset($q->criterion->criteria);

        $this->assertInstanceOf(
            'eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeGroupId',
            $criteria
        );
        $this->assertEquals(7, $criteria->value);

    }

    public function testContentTypeIdentifer()
    {
        $qb = new QueryBuilder();
        $q = $qb->contentTypeIdentifier('blog_post')->query;

        $this->checkCriteria(
            $q,
            'eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier',
            'blog_post',
            'string'
        );
    }
}
