<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage;

use kar1gan\TestClientComposerPackage\DataTransferObject\Comment;
use kar1gan\TestClientComposerPackage\Service\CurlService;

/**
 * Репозиторий комментариев
 */
class CommentsRepository implements CommentsRepositoryInterface {

	/** Сервис отправки запросов */
	private CurlService $service;

	private const ENDPOINT = 'http://example.com/comments/';

	public function __construct() {
		$this->service = new CurlService();
	}

	/**
	 * @inheritDoc
	 *
	 * @throws \Throwable
	 */
	public function getComments(): array {
		$rawComments = $this->service->send(self::ENDPOINT, '', 'GET');

		$comments = [];
		foreach ($rawComments as $rawComment) {
			if (false === is_int($id = $rawComment[Comment::ATTR_ID] ?? null)) {
				throw new \Exception('Id not passed or wrong type');
			}

			if (false === is_string($name = $rawComment[Comment::ATTR_NAME] ?? null)) {
				throw new \Exception('Name not passed or wrong type');
			}

			if (false === is_string($text = $rawComment[Comment::ATTR_TEXT] ?? null)) {
				throw new \Exception('Text not passed or wrong type');
			}

			$comments[] = new Comment($id, $name, $text);
		}

		return $comments;
	}

	/**
	 * @inheritDoc
	 *
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function addComment(Comment $comment): bool {
		if (null === ($name = $comment->getName())) {
			throw new \Exception('Author name can`t be equal null');
		}

		if (null === ($text = $comment->getText())) {
			throw new \Exception('Comment text can`t be equal null');
		}

		$body = [Comment::ATTR_NAME => $name, Comment::ATTR_TEXT => $text];

		return $this->service->send(self::ENDPOINT, json_encode($body), 'POST');
	}

	/**
	 * @inheritDoc
	 *
	 * @throws \Exception
	 * @throws \Throwable
	 */
	public function changeComment(Comment $comment): bool {
		if (null === $comment->getId()) {
			throw new \Exception('Id can`t be empty');
		}

		if (null === $comment->getName() && null === $comment->getText()) {
			throw new \Exception('Author name and comment text cannot be empty at the same time');
		}

		$body = [Comment::ATTR_NAME => $comment->getName(), Comment::ATTR_TEXT => $comment->getText()];
		$body = array_filter($body);

		return $this->service->send(self::ENDPOINT . $comment->getId(), json_encode($body), 'PUT');
	}
}
