<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\Service;

use kar1gan\TestClientComposerPackage\DataTransferObject\Comment;

/**
 * Заглушка сервиса отправки запросов
 */
class DummyRequestSender implements RequestSenderInterface {

	/** @var Comment[] Комментарии  */
	private array $comments;

	/**
	 * @param Comment[] $comments Комментарии
	 */
	public function __construct(array $comments = []) {
		$this->comments[] = new Comment(1, 'Penny', 'wow such a cool service!');
		$this->comments[] = new Comment(2, 'Helen', 'what a genius created it?!');
		$this->comments[] = new Comment(3, 'Patricia', 'you know you should give him an offer..');

		if ([] !== $comments) {
			$this->comments = $comments;
		}
	}

	/**
	 * @inheritDoc
	 *
	 * @throws \Exception
	 */
	public function send(string $endpoint, string $body, string $httpMethod): array|bool {
		return match ($httpMethod) {
			'GET'  => $this->returnComments(),
			'POST' => $this->addComment($body),
			'PUT'  => $this->changeComment($endpoint, $body)
		};
	}

	/**
	 * @return array
	 */
	private function returnComments(): array {
		return json_decode(json_encode($this->comments), true);
	}

	/**
	 * @param string $body Тело запроса
	 *
	 * @return bool
	 */
	private function addComment(string $body): bool {
		$rawComment = json_decode($body, true);
		$id         = array_key_last($this->comments) + 1;
		$this->comments[$id] = new Comment(
			$id,
			$rawComment[Comment::ATTR_NAME],
			$rawComment[Comment::ATTR_TEXT]
		);

		return true;
	}

	/**
	 * @param string $endpoint Урл
	 * @param string $body     Тело запроса
	 *
	 * @return bool
	 */
	private function changeComment(string $endpoint, string $body): bool {
		$explodedEndpoint = explode('/', $endpoint);
		$id               = intval(end($explodedEndpoint));

		$commentToChange = array_filter($this->comments, function(Comment $comment) use ($id): bool {
			return ($id === $comment->getId());
		});

		if ([] === $commentToChange) {
			return false;
		}

		$body = json_decode($body, true);
		if (null === ($name = $body[Comment::ATTR_NAME] ?? null) && null === ($text = $body[Comment::ATTR_TEXT] ?? null)) {
			return false;
		}

		$newComment = new Comment(
			$id,
			$name ?? reset($commentToChange)->getName(),
			$text ?? reset($commentToChange)->getText()
		);

		$this->comments[$id] = $newComment;

		return true;
	}
}
