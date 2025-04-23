<?php

namespace Elgg\Library;

use Elgg\DefaultPluginBootstrap;
use Elgg\Traits\Di\ServiceFacade;

/**
 * Bootstrap for the Library plugin
 */
class Bootstrap extends DefaultPluginBootstrap {

    use ServiceFacade;

    /**
     * Returns the name of the plugin
     *
     * @return string
     */
    public static function name(): string {
        return 'library';
    }

    /**
     * {@inheritdoc}
     */
    public function boot() {
        // Register hooks during boot
        elgg_extend_view('elgg.css', 'library/library.css');
    }

    /**
     * {@inheritdoc}
     */
    public function init() {
        // Register hooks and event handlers
        elgg_register_plugin_hook_handler('register', 'menu:owner_block', [$this, 'setupOwnerBlockMenu']);
        elgg_register_plugin_hook_handler('register', 'menu:site', [$this, 'setupSiteMenu']);
        elgg_register_plugin_hook_handler('entity:url', 'object', [$this, 'setURL']);
        elgg_register_plugin_hook_handler('extender:url', 'volatile', [$this, 'annotationURL']);
    }

    /**
     * Setup the site menu
     *
     * @param \Elgg\Hook $hook Hook
     * @return \Elgg\Menu\MenuItems
     */
    public function setupSiteMenu(\Elgg\Hook $hook) {
        $menu = $hook->getValue();
        
        $menu->add(\ElggMenuItem::factory([
            'name' => 'library',
            'text' => elgg_echo('library'),
            'href' => elgg_generate_url('collection:object:library_book:all'),
        ]));
        
        return $menu;
    }

    /**
     * Setup the owner block menu
     *
     * @param \Elgg\Hook $hook Hook
     * @return \Elgg\Menu\MenuItems
     */
    public function setupOwnerBlockMenu(\Elgg\Hook $hook) {
        $menu = $hook->getValue();
        $entity = $hook->getEntityParam();
        
        if ($entity instanceof \ElggUser) {
            $menu->add(\ElggMenuItem::factory([
                'name' => 'library',
                'text' => elgg_echo('library'),
                'href' => elgg_generate_url('collection:object:library_book:owner', [
                    'username' => $entity->username,
                ]),
            ]));
        }
        
        return $menu;
    }

    /**
     * Format and return the URL for library book entities
     *
     * @param \Elgg\Hook $hook Hook
     * @return string|null
     */
    public function setURL(\Elgg\Hook $hook) {
        $entity = $hook->getEntityParam();
        
        if ($entity instanceof LibraryBook) {
            return elgg_generate_url('default:object:library_book', [
                'guid' => $entity->guid,
                'title' => elgg_get_friendly_title($entity->getDisplayName()),
            ]);
        }
        
        return null;
    }

    /**
     * Return the URL of a borrow annotation
     *
     * @param \Elgg\Hook $hook Hook
     * @return string|null
     */
    public function annotationURL(\Elgg\Hook $hook) {
        $annotation = $hook->getParam('extender');
        
        if (!$annotation instanceof \ElggAnnotation) {
            return null;
        }
        
        if ($annotation->name !== 'borrow') {
            return null;
        }
        
        $entity = get_entity($annotation->entity_guid);
        if (!$entity instanceof LibraryBook) {
            return null;
        }
        
        return elgg_generate_url('default:object:library_book', [
            'guid' => $entity->guid,
            'title' => elgg_get_friendly_title($entity->getDisplayName()),
        ]);
    }
}

