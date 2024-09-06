<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        // Add the client connection to the list of connected clients
        $this->clients->attach($conn);
        echo "New client connected ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Broadcast the received message to all connected clients except the sender
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove the client connection from the list of connected clients
        $this->clients->detach($conn);
        echo "Client disconnected ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Handle errors that occur on the WebSocket connection
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

?>
