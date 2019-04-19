<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
	/**
	 * Fonction getConfiguration
	 * Permet d'avoir la configuration de base d'un champ de formulaire.
	 *
	 * @param        $label
	 * @param string $placeholder
	 * @param array  $options
	 * @return array
	 */
	protected function getConfiguration($label, string $placeholder, array $options = []): array
	{
		return array_merge([
			'label' => $label,
			'attr' => [
				'placeholder' => $placeholder
			]
		], $options);
	}
}