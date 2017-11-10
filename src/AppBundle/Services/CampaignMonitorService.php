<?php

namespace AppBundle\Services;

use AppBundle\Subscriber\CampaignMonitorSubscriber;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * Class CampaignMonitorService
 * @package AppBundle\Services
 */
class CampaignMonitorService 
{
    /**
     * @var CampaignMonitorSubscriber
     */
    protected $campaignMonitorSubscriber;

    /**
     * CampaignMonitorService constructor.
     * @param CampaignMonitorSubscriber $campaignMonitorSubscriber
     */
    public function __construct(CampaignMonitorSubscriber $campaignMonitorSubscriber, Translator $translator)
    {
        $this->campaignMonitorSubscriber = $campaignMonitorSubscriber;
        $this->translator = $translator;
    }

    /**
     * @param string $email
     * @param string $name
     * @return array
     */
    public function subscribe(string $email, string $name): array 
    {
        return $this->campaignMonitorSubscriber->subscribe($email,$name);        
    }

    /**
     * @param string $email
     * @return array
     */
    public function unsubscribe(string $email): array
    {       
        return $this->campaignMonitorSubscriber->unsubscribe($email);        
    }

    /**
     * @param string $email
     * @return array
     */
    public function delete(string $email): array
    {
        return $this->campaignMonitorSubscriber->delete($email);
    }

    /**
     * @param string $added_since
     * @param null $page_number
     * @param null $page_size
     * @param null $order_field
     * @param null $order_direction
     * @return array
     */
    public function getActiveSubscribers($added_since = '', $page_number = NULL,
        $page_size = NULL, $order_field = NULL, $order_direction = NULL): array
    {
        $results = $this->campaignMonitorSubscriber->getActiveSubscribers($added_since, $page_number,
            $page_size, $order_field, $order_direction);
        $data = [];
        $i = 0;
        //manipulate data to served in datatables.
        foreach($results['data']->response->Results as $result){
            $data[$i]['email'] = $result->EmailAddress;
            $data[$i]['name'] = $result->Name;
            $data[$i]['created'] = $result->Date;
            $data[$i]['status'] = $result->State;
            $data[$i]['delete'] = NULL;
            $i++;
        }
        return $data;
    }
}
