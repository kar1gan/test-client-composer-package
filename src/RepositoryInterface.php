<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage;

use kar1gan\TestClientComposerPackage\DataTransferObject\Comment;

/**
 * Интерфейс репозитория комментариев
 */
interface RepositoryInterface {

	/**
	 * Получить комментарии
	 *
	 * @return Comment[]
	 */
	public function getComments(): array;

	/**
	 * Добавить комментарий
	 *
	 * @param Comment $comment Объект комментария
	 *
	 * @return bool
	 */
	public function addComment(Comment $comment): bool;

	/**
	 * Изментить комментарий по идентификатору
	 *
	 * @param Comment $comment Объект комментария
	 *
	 * @return bool
	 */
	public function changeComment(Comment $comment): bool;
}
