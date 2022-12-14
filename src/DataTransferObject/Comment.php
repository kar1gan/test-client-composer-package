<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\DataTransferObject;

/**
 * Модель комментария
 */
class Comment implements \JsonSerializable {

	public const ATTR_ID   = 'id';
	public const ATTR_NAME = 'name';
	public const ATTR_TEXT = 'text';

	/**
	 * @param int|null    $id   Идентификатор комментария
	 * @param string|null $name Имя комментатора
	 * @param string|null $text Текст комментария
	 */
	public function __construct(
		private ?int    $id,
		private ?string $name,
		private ?string $text
	) {}

	/**
	 * Получить идентификатор комментария
	 *
	 * @return int|null
	 */
	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * Получить имя комментатора
	 *
	 * @return string|null
	 */
	public function getName(): ?string {
		return $this->name;
	}

	/**
	 * Получить текст комментария
	 *
	 * @return string|null
	 */
	public function getText(): ?string {
		return $this->text;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize(): array {
		return [
			self::ATTR_ID   => $this->id,
			self::ATTR_NAME => $this->name,
			self::ATTR_TEXT => $this->text
		];
	}
}
