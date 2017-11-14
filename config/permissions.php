<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use OurSociety\Action\Admin\Users\ImpersonateUserAction;

/**
 * Rules are evaluated top-down, first matching rule will apply.
 *
 * Syntax:
 *
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 *
 * - You can use '*' to match anything
 * - 'allowed' will be considered true if not defined. It allows a callable to manage complex permissions, like this
 *        'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * [
 *     'role' => ['user'],
 *     'controller' => ['Posts'],
 *     'action' => ['edit', 'delete'],
 *     'allowed' => function(array $user, $role, Request $request) {
 *         $postId = Hash::get($request->params, 'pass.0');
 *         $post = TableRegistry::get('Posts')->get($postId);
 *         $userId = Hash::get($user, 'id');
 *         if (!empty($post->user_id) && !empty($userId)) {
 *             return $post->user_id === $userId;
 *         }
 *         return false;
 *     }
 * ],
 */

return [
    'CakeDC/Auth.permissions' => [
        [
            'controller' => 'Pages',
            'action' => 'display',
            'bypassAuth' => true,
        ],
        [
            'controller' => 'Users',
            'action' => ['login', 'register', 'forgot', 'verify', 'logout', 'reset'],
            'bypassAuth' => true,
        ],
        [
            'plugin' => 'DebugKit',
            'controller' => '*',
            'action' => '*',
            'bypassAuth' => function (array $user, string $role, ServerRequest $request) {
                return Configure::read('debug') === true;
            },
        ],
        [
            'role' => ['citizen', 'politician'],
            'prefix' => 'admin',
            'controller' => 'Users',
            'action' => ['switch'],
            'allowed' => function (array $user, string $role, ServerRequest $request) {
                return $request->getSession()->read(ImpersonateUserAction::SESSION_KEY_ADMIN) !== null;
            },
        ],
        // Catch-all
        [
            'role' => 'citizen',
            'prefix' => 'citizen',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        [
            'role' => 'politician',
            'prefix' => 'politician',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        [
            'role' => 'admin',
            'prefix' => '*',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        [
            'role' => '*',
            'prefix' => false,
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
            'bypassAuth' => true,
        ],
    ],
];
