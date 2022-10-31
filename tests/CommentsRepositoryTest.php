<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\Test;

use kar1gan\TestClientComposerPackage\CommentsRepository;
use kar1gan\TestClientComposerPackage\DataTransferObject\Comment;
use kar1gan\TestClientComposerPackage\Service\DummyRequestSender;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование репозитория комментариев
 */
class CommentsRepositoryTest extends TestCase {

	/** Репозиторий комментариев */
	private CommentsRepository $repository;

	/**
	 * @inheritDoc
	 */
	protected function setUp(): void {
		$this->repository = new CommentsRepository(new DummyRequestSender());
	}

	/**
	 * Тестирование исключения при пустом имени автора при добавлении комментария
	 *
	 * @covers CommentsRepository::addComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionInAddCommentMethodIfAuthorNameIsNull(): void {
		$comment = new Comment(1, null, 'text');

		$this->expectException(\Exception::class);
		$this->repository->addComment($comment);
	}

	/**
	 * Тестирование исключения при пустом тексте при добалвении комментария
	 *
	 * @covers CommentsRepository::addComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionInAddCommentMethodIfTextIsNull(): void {
		$comment = new Comment(1, 'name', null);

		$this->expectException(\Exception::class);
		$this->repository->addComment($comment);
	}

	/**
	 * Тестирование исключение при пустом идентификаторе комментария
	 *
	 * @covers CommentsRepository::changeComment
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
	 * @covers CommentsRepository::changeComment
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

	/**
	 * Тестирование исключения при невалидном идентификаторе при получении комментариев
	 *
	 * @covers CommentsRepository::getComments
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionIfIdFieldIsNotValidInGetCommentsMethod(): void {
		$service    = new DummyRequestSender([new Comment(null, 'name', 'text')]);
		$repository = new CommentsRepository($service);

		$this->expectException(\Exception::class);
		$repository->getComments();
	}

	/**
	 * Тестирование исключения при невалидном имени автора при получении комментариев
	 *
	 * @covers CommentsRepository::getComments
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionIfIdFieldNameNotValidInGetCommentsMethod(): void {
		$service    = new DummyRequestSender([new Comment(100, null, 'text')]);
		$repository = new CommentsRepository($service);

		$this->expectException(\Exception::class);
		$repository->getComments();
	}

	/**
	 * Тестирование исключения при невалидном тексте комментария при получении комментариев
	 *
	 * @covers CommentsRepository::getComments
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testExceptionIfIdFieldTextNotValidInGetCommentsMethod(): void {
		$service    = new DummyRequestSender([new Comment(100, 'name', null)]);
		$repository = new CommentsRepository($service);

		$this->expectException(\Exception::class);
		$repository->getComments();
	}

	/**
	 * Тестирование успешного ответа при получении комментариев
	 *
	 * @covers CommentsRepository::getComments
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testSuccessResponseInGetCommentsMethod(): void {
		$comments = $this->repository->getComments();

		self::assertNotEmpty($comments);
		foreach ($comments as $comment) {
			self::assertIsInt($comment->getId());
			self::assertIsString($comment->getName());
			self::assertIsString($comment->getText());
		}
	}

	/**
	 * Тестирование успешного ответа при добавлении комментария
	 *
	 * @covers CommentsRepository::addComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testSuccessResponseInAddCommentMethod(): void {
		$comment = new Comment(100, 'name', 'text');

		$result = $this->repository->addComment($comment);
		self::assertIsBool($result);
		self::assertSame(true, $result);
	}

	/**
	 * Тестирование успешного ответа при изменении комментария
	 *
	 * @covers CommentsRepository::changeComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testSuccessResponseInChangeCommentMethod(): void {
		$comment = new Comment(3, 'Aleksey', 'can i go to step 3?');

		$result = $this->repository->changeComment($comment);
		self::assertIsBool($result);
		self::assertSame(true, $result);
	}

	/**
	 * Тестирование негативного ответа при измеении комментария
	 *
	 * @covers CommentsRepository::changeComment
	 *
	 * @throws \Throwable
	 *
	 * @return void
	 */
	public function testFalseResultIfCommentNotExistInChangeCommentMethod(): void {
		$comment = new Comment(999, 'comment is not', 'exist');

		$result = $this->repository->changeComment($comment);
		self::assertIsBool($result);
		self::assertSame(false, $result);
	}
}
