<?php

declare(strict_types=1);

namespace S3bul\ImapBundle\Service;

use S3bul\PhpImap\Mailbox;
use SecIT\ImapBundle\Service\Imap as BaseImap;

/**
 * Class Imap
 *
 * @author Sebastian Korzeniecki <seba5zer@gmail.com>
 * @package S3bul\ImapBundle\Service
 */
class Imap extends BaseImap
{

    /**
     * Get new mailbox instance.
     *
     * @param string $name
     *
     * @return Mailbox
     *
     * @throws \Exception
     */
    protected function getMailbox($name)
    {
        if(!isset($this->connections[$name])) {
            throw new \Exception(sprintf('Imap connection %s is not configured.', $name));
        }

        $config = $this->connections[$name];

        if(isset($config['attachments_dir'])) {
            $this->checkAttachmentsDir(
                $config['attachments_dir'],
                $config['create_attachments_dir_if_not_exists'],
                $config['created_attachments_dir_permissions']
            );
        }

        return new Mailbox(
            $config['mailbox'],
            $config['username'],
            $config['password'],
            $config['attachments_dir'] ?? null,
            $config['server_encoding'] ?? 'UTF-8'
        );
    }

}
