<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\Test;

use kar1gan\TestClientComposerPackage\CommentsRepository;
use kar1gan\TestClientComposerPackage\DataTransferObject\Comment;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование репозитория комментариев
 */
class CommentsRepositoryTest extends TestCase {

	private CommentsRepository $repository;

	protected function setUp(): void {
		$this->repository = new CommentsRepository();
	}

	/**
	 * Тестирование исключения при пустых имени автора и тексте комментария
	 *
	 * @covers \kar1gan\TestClientComposerPackage\CommentsRepository::addComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionInAddCommentMethodIfNameAndTextIsNull(): void {
		$comment = new Comment(1, null, null);

		$this->expectException(\Exception::class);
		$this->repository->addComment($comment);
	}

	/**
	 * Тестирование исключение при пустом идентификаторе комментария
	 *
	 * @covers \kar1gan\TestClientComposerPackage\CommentsRepository::changeComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionInChangeCommentMethodIfIdIsNull(): void {
		$comment = new Comment(null, 'name', 'text');

		$this->expectException(\Exception::class);
		$this->repository->changeComment($comment);
	}

	/**
	 * Тестирвоание исключение при пустом имени автора/тексте комментария
	 *
	 * @covers \kar1gan\TestClientComposerPackage\CommentsRepository::changeComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionInChangeCommentMethodIfNameAndTextIsNull(): void {
		$comment = new Comment(1, null, null);

		$this->expectException(\Exception::class);
		$this->repository->changeComment($comment);
	}
}
