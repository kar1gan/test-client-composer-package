<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\DataTransferObject;

/**
 * Модель коментария
 */
class Comment {

	public const ATTR_ID   = 'id';
	public const ATTR_NAME = 'name';
	public const ATTR_TEXT = 'text';

	/**
	 * @param int         $id   Идентификатор комментария
	 * @param string|null $name Имя комментатора
	 * @param string|null $text Текст комментария
	 */
	public function __construct(
		private int    $id,
		private ?string $name,
		private ?string $text
	) {}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * @return string|null
	 */
	public function getText(): ?string {
		return $this->text;
	}
}
