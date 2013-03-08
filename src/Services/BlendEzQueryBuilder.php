<?php
/**
 * A class designed to simplify the creation of search queries
 * against the eZ Publish Public API
 *
 * Author: Joe Kepley
 * Date: 3/8/13
 */
namespace Blend\EzQueryBuilderBundle\Services;
use eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeGroupId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\DateMetadata,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Field,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\FullText,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LanguageCode,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationRemoteId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\MoreLikeThis,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\ParentLocationId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\RemoteId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\SectionId,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Status,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Subtree,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\UrlAlias,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalOr,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalNot,
    eZ\Publish\API\Repository\Values\Content\Query\SortClause,
    eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;

class BlendEzQueryBuilder
{
    /**
     * @var Query
     */
    public $query;

    public function __construct()
    {
        $this->query = new Query();
        $this->query->criterion = new LogicalAnd(array());
    }

    /* Base functions to add query elements */

    /**
     * Add an addition criterion to the query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface $criterion
     */
    public function criterion( CriterionInterface $criterion )
    {
        $this->query->criterion->criteria[]=$criterion;
        return $this;
    }

    public function sortClause( SortClause $clause )
    {
        $this->query->sortClauses[]=$clause;
        return $this;
    }

    public function offset( $offset )
    {
        $this->query->offset = $offset;
        return $this;
    }

    public function limit( $limit )
    {
        $this->query->limit = $limit;
        return $this;
    }

    /* Helper functions to provide IDE-friendliness for builtin types */


    /**
     * Find a specific content ID (object ID)
     * @param int $contentId
     */
    public function contentId( $contentId )
    {
        return $this->criterion(new ContentId($contentId));
    }

    /**
     * Restrict search to content in the content type group.
     * ID can be found in Setup->Classes in the admin interface as Class Group ID
     * @param int $contentTypeGroupId
     */
    public function contentTypeGroupId( $contentTypeGroupId )
    {
        return $this->criterion(new ContentTypeGroupId($contentTypeGroupId));
    }

    /**
     * Restrict search to a specific content type by ID.
     * ID can be found in Setup->Classes as Class ID.
     * @param $contentTypeId
     */
    public function contentTypeId( $contentTypeId )
    {
        return $this->criterion(new ContentTypeId($contentTypeId));
    }

    /**
     * Restrict search to a specific content type by identifier.
     * @param $contentTypeIdentifier
     */
    public function contentTypeIdentifier( $contentTypeIdentifier )
    {
        return $this->criterion(new ContentTypeIdentifier($contentTypeIdentifier));
    }

    /**
     * Restrict search by date created
     * @param string $operator
     * @param mixed $value
     */
    public function dateCreated( $operator, $value )
    {
        return $this->criterion(new DateMetadata( DateMetadata::CREATED, $operator, $value ));
    }

    public function dateModified( $operator, $value )
    {
        return $this->criterion(new DateMetadata( DateMetadata::MODIFIED, $operator, $value));
    }

    public function field( $fieldIdentifier, $operator, $value )
    {
        return $this->criterion(new Field($fieldIdentifier, $operator, $value) );
    }

    public function parentLocationId( $locationId )
    {
        return $this->criterion(new ParentLocationId($locationId));
    }

    public function subtree( $subtreePath )
    {
        return $this->criterion(new Subtree($subtreePath));
    }

}
