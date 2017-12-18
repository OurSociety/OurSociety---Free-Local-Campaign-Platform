<?php
declare(strict_types=1);

namespace OurSociety\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Imagick;
use OurSociety\Model\Entity\User;
use OurSociety\Model\Table\UsersTable;
use OurSociety\Test\Fixture\UsersFixture;
use Spatie\Browsershot\Browsershot;

/**
 * Screenshot shell command.
 */
class ScreenshotShell extends AppShell
{
    public const USER_AGENT = 'BrowserShot';
    private const BREAKPOINTS = [
        'phone' => 400,
        'tablet' => 768,
        'desktop' => 1200,
    ];
    private const PAGES = [
        [
            'name' => 'landing',
            'url' => ['_name' => 'root'],
            'auth' => false,
        ],
        [
            'name' => 'home',
            'url' => ['_name' => 'home'],
            'auth' => false,
        ],
        [
            'name' => 'user-forgot-password',
            'url' => ['_name' => 'users:forgot'],
            'auth' => false,
        ],
        [
            'name' => 'user-login',
            'url' => ['_name' => 'users:login'],
            'auth' => false,
        ],
        [
            'name' => 'user-logout',
            'url' => ['_name' => 'users:logout'],
            'auth' => false,
        ],
        [
            'name' => 'user-profile-edit',
            'url' => ['_name' => 'citizen:profile:edit'],
            'auth' => true,
        ],
        [
            'name' => 'user-profile',
            'url' => ['_name' => 'citizen:profile'],
            'auth' => true,
        ],
        [
            'name' => 'user-register',
            'url' => ['_name' => 'users:register'],
            'auth' => false,
        ],
        [
            'name' => 'user-reset-password',
            'url' => ['_name' => 'users:reset'],
            'auth' => false,
        ],
        [
            'name' => 'user-onboarding',
            'url' => ['_name' => 'users:onboarding'],
            'auth' => true,
        ],
        [
            'name' => 'citizen-dashboard',
            'url' => ['_name' => 'citizen:dashboard'],
            'auth' => true,
        ],
        [
            'name' => 'citizen-questions',
            'url' => ['_name' => 'citizen:questions'],
            'auth' => true,
        ],
        [
            'name' => 'politician-dashboard',
            'url' => ['_name' => 'politician:dashboard'],
            'auth' => true,
        ],
        [
            'name' => 'politician-questions',
            'url' => ['_name' => 'politician:questions'],
            'auth' => true,
        ],
        [
            'name' => 'admin-dashboard',
            'url' => ['_name' => 'admin:dashboard'],
            'auth' => true,
        ],
        [
            'name' => 'admin-questions',
            'url' => ['_name' => 'admin:questions'],
            'auth' => true,
        ],
    ];

    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser()
            ->addSubcommand('all', [
                'help' => 'Take screenshots of all pages.',
            ]);
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());

        return false;
    }

    /**
     * all() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function all()
    {
        $this->out('Taking screenshots...');

        /** @var UsersTable $users */
        $users = TableRegistry::get('users');
        /** @var User $user */
        $user = $users->find('auth')->where(['email' => UsersFixture::ADMIN_EMAIL])->firstOrFail();

        foreach (self::BREAKPOINTS as $breakpointName => $breakpointWidth) {
            foreach (self::PAGES as $page) {
                Configure::write('App.fullBaseUrl', sprintf('http://%s', env('APP_DOMAIN')));
                $url = Router::url($page['url'], true);
                $filename = sprintf(TMP . 'screenshots/%s/%s.png', $breakpointName, $page['name']);
                //$filename = sprintf('%s/Google Drive/Clients/OurSociety/Screenshots/%s.png', env('HOME'), $filename);
                new Folder(dirname($filename), true);

                if ((new File($filename))->exists()) {
                    $this->out(sprintf('- Skipping %s as it already exists', $filename));
                    continue;
                }

                $this->out(sprintf('- %s to %s', $url, $filename));

                $userAgent = self::USER_AGENT;
                if ($page['auth'] ?? false) {
                    $userAgent .= sprintf(' (%s)', $user->password);
                }
                $browser = Browsershot::url($url)->userAgent($userAgent)->windowSize($breakpointWidth, 10000);

                $macosCanaryPath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
                if ((new File($macosCanaryPath))->exists()) {
                    $browser->setChromePath($macosCanaryPath);
                }

                $browser->save($filename);

                $this->trimScreenshot($filename);
            }
        }

        return true;
    }

    /**
     * Trim image bottom.
     *
     * Sets top-left pixel to red first, so it doesn't trim top or left sides of image.
     *
     * @param string $filename
     * @return void
     */
    private function trimScreenshot(string $filename): void
    {
        $image = new Imagick($filename);
        $oldColor = $this->setTopLeftPixelColor($image, 'red');
        $image->trimImage(0);
        $this->setTopLeftPixelColor($image, $oldColor);
        $image->writeImage($filename);
    }

    /**
     * Sets the top-left pixel color and returns the old color.
     *
     * @param Imagick $image
     * @param string $color
     * @return string
     */
    private function setTopLeftPixelColor(Imagick $image, string $color): string
    {
        $iterator = $image->getPixelIterator();
        $iterator->setIteratorRow(0);
        $row = $iterator->getCurrentIteratorRow();
        /** @var \ImagickPixel $pixel */
        $pixel = $row[0];
        $oldColor = $pixel->getColorAsString();
        $pixel->setColor($color);
        $iterator->syncIterator();

        return $oldColor;
    }
}
