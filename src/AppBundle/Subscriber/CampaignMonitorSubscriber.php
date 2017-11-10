<?php

namespace AppBundle\Subscriber;

class CampaignMonitorSubscriber implements MailerSubscriber
{
    /**
     * @var \CS_REST_Subscribers
     */
    protected $apiSubscribers;

    /**
     * @var string
     */
    protected $listId;

    /**
     * CampaignMonitorSubscriber constructor.
     * @param string $apiKey
     * @param string $listId
     */
    public function __construct(string $apiKey, string $listId)
    {
        $this->apiSubscribers = new \CS_REST_Subscribers($listId,[
                'api_key' => $apiKey,
            ]
        );
        $this->apiList = new \CS_REST_Lists($listId,[
            'api_key' => $apiKey,
        ]);
        $this->listId = $listId;
    }

    /**
     * @return $this
     */
    private function getListId(): string
    {
        return $this->listId;
    }

    /**
     * @param string $listId
     */
    private function setListId(string $listId): void
    {
        if ($listId !== $this->listId) {
            $this->apiSubscribers->set_list_id($listId);
        }
    }

    /**
     * @param string $email
     * @param string $listId
     * @return bool
     */
    public function isSubscribed(string $email): bool
    {
        try {
            $result = $this->apiSubscribers->get($email);
            return $result->was_successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $listId
     * @return bool
     */
    public function subscribe(string $email, string $name): array
    {
        try {
            if($this->isSubscribed($email)){
                $result = $this->apiSubscribers->update($email,[
                    'EmailAddress' => $email,
                    'name' => $name,
                    'Resubscribe' => true
                ]);
            }else{
                $result = $this->apiSubscribers->add([
                    'EmailAddress' => $email,
                    'name' => $name,
                ]);
            }
            if($result->was_successful() == 200){
                return ['success' => true];
            }
            return [ 'success' => false, 'message'=> $result->response];
        } catch (\Exception $e) {
            return ['success' => false, 'message'=> $e->getMessage()];
        }
    }

    /**
     * @param string $email
     * @param string $listId
     * @return array
     */
    public function unsubscribe(string $email): array
    {
        try {
            $result = $this->apiSubscribers->unsubscribe($email);
            if($result->was_successful() == 200){
                return ['success' => true];
            }
            return ['success' => false, 'message'=> $result->response];
        } catch (\Exception $e) {
            return ['success' => false, 'message'=> $e->getMessage()];
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    public function delete(string $email): array
    {
        try {
            $result = $this->apiSubscribers->delete($email);
            if($result->was_successful() == 200){
                return ['success' => true];
            }
            return ['success' => false, 'message'=> $result->response];
        } catch (\Exception $e) {
            return ['success' => false, 'message'=> $e->getMessage()];
        }
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
        try {
            $results = $this->apiList->get_active_subscribers($added_since, $page_number,
                $page_size, $order_field, $order_direction);

            if($results->was_successful() == 200){
                return ['success' => true, 'data' => $results];
            }else{
                return ['success' => false, 'message'=> $results->response];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message'=> $e->getMessage()];
        }
    }
}