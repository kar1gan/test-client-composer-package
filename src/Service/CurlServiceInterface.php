<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\Service;

/**
 * Интерфейс сервиса отправки запросов
 */
interface CurlServiceInterface {

	/**
	 * Отправить запрос
	 *
	 * @param string $endpoint   Урл
	 * @param string $body       Тело запроса
	 * @param string $httpMethod Метод запроса
	 *
	 * @return mixed
	 */
	public function send(string $endpoint, string $body, string $httpMethod): mixed;
}
