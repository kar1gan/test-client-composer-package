<?php

declare(strict_types=1);

namespace kar1gan\TestClientComposerPackage\Service;

/**
 * Сервисе отравки запросов через curl
 */
class CurlRequestSender implements RequestSenderInterface {

	/**
	 * @inheritDoc
	 *
	 * @throws \Exception
	 */
	public function send(string $endpoint, string $body, string $httpMethod): mixed {
		if (false === ($handle = curl_init())) {
			throw new \Exception('Can`t initialize a cURL session');
		}

		curl_setopt_array($handle, [
			CURLOPT_URL            => $endpoint,
			CURLOPT_POSTFIELDS     => $body,
			CURLOPT_CUSTOMREQUEST  => $httpMethod,
			CURLOPT_HTTPHEADER     => [
				'Content-type: application/json',
			],
			CURLOPT_ENCODING       => 'UTF-8',
			CURLOPT_RETURNTRANSFER => true,
		]);

		$response = curl_exec($handle);

		curl_close($handle);

		if (false === $response || CURLE_OK !== curl_errno($handle)) {
			throw new \Exception('Received some error while getting a response');
		}

		return json_decode($response, true);
	}
}
