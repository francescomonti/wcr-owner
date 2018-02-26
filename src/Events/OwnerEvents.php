<?php

namespace Wcr\Owner\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Wcr\Owner\Owner;

class OwnerEvents
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function entityCreated ($entity)
    {
        //echo '<pre>'.print_r($entity, true).'</pre>';
        $owner = new Owner();
        $owner->entity_type = get_class($entity);
        $owner->entity_id = $entity->id;
        $owner->user_id = auth()->user()->id;
        $owner->save();
        //echo '<pre>'.print_r($owner, true).'</pre>';
        //exit();
    }

    public function entityUpdated ($entity)
    {
        /*echo '<pre>'.print_r($entity, true).'</pre>';
        exit();*/
    }

    public function entityDeleted ($entity)
    {   
        $count = Owner::where('entity_id', '=', $entity->id)->count();
        if ($count>0) {
            $owner = Owner::where('entity_id', '=', $entity->id)->firstOrFail();
            $owner->delete();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
