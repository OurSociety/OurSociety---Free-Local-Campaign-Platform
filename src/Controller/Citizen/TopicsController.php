<?php
namespace OurSociety\Controller\Citizen;

use OurSociety\Controller\AppController;
use OurSociety\Model\Entity\Category;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Topics Controller
 *
 *
 * @method Category[] paginate($object = null, array $settings = [])
 */
class TopicsController extends AppController
{
    public function compare(string $politician): ?Response
    {
        $this->set([
            'politician' => $this->loadModel('Users')
                ->find('politicianForCitizen')
                ->where(['slug' => $politician])
                ->firstOrFail(),
        ]);

        return null;
    }
}
