<?php

declare(strict_types=1);

namespace hypeJunction\Payments;

use Elgg\Database\Seeds\Seed;

class Seeder extends Seed {

	public function getType(): string {
		return 'hypepayments';
	}

	public function seed(): void {
		$this->advance('Seeding hypepayments entities...');

		$count = $this->getCount();

		for ($i = 0; $i < $count; $i++) {
			$user = $this->getRandomUser();
			if (!$user) {
				continue;
			}

			// TODO: Create a Transaction entity with faker data
			// $entity = new \hypeJunction\Payments\Transaction();
			// $entity->owner_guid = $user->guid;
			// $entity->container_guid = $user->guid;
			// $entity->title = $this->faker()->sentence();
			// $entity->description = $this->faker()->paragraph();
			// $entity->save();

			// Tag for cleanup:
			// $entity->setMetadata('__faker', true);

			$this->advance();
		}
	}

	public function unseed(): void {
		$batch = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'transaction',
			'metadata_name' => '__faker',
			'metadata_value' => true,
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);

		foreach ($batch as $entity) {
			$entity->delete();
			$this->advance();
		}
	}

	public static function addSeed(\Elgg\Event $event): mixed {
		$seeds = $event->getValue();
		$seeds[] = static::class;
		return $seeds;
	}

	public function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => 'transaction',
		];
	}
}
