<?php

/**
 * @package redaxo\structure
 *
 * @internal
 */
class rex_api_category_add extends rex_api_function
{
    public function execute()
    {
        if (!rex::requireUser()->hasPerm('addCategory[]')) {
            throw new rex_api_exception('User has no permission to add categories!');
        }

        $parentId = rex_request('parent-category-id', 'int');

        // check permissions
        if (!rex::requireUser()->getComplexPerm('structure')->hasCategoryPerm($parentId)) {
            throw new rex_api_exception('user has no permission for this category!');
        }

        // prepare and validate parameters
        $data = [];
        $data['catpriority'] = rex_post('category-position', 'int');
        $data['catname'] = rex_post('category-name', 'string');
        return new rex_api_result(true, rex_category_service::addCategory($parentId, $data));
    }

    protected function requiresCsrfProtection()
    {
        return true;
    }
}
