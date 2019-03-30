<?php

declare(strict_types=1);

namespace zalatov\viewfile;

use Throwable;
use Yii;
use yii\base\Controller;

/**
 * Базовый класс для файлов шаблонов.
 *
 * Основная идея - использовать именно классы для отрисовки вьюшек.
 * В чём плюсы:
 * 1) Использование Find Usages в IDE
 * 2) Указание и нативная проверка обязательных параметров
 * 3) phpdoc (описание) для параметров
 * 4) Использование разделения и поиска вьюшек через namespace’ы
 *
 * @author Zalatov Alexander <zalatov.ao@gmail.com>
 */
abstract class ViewFile {
	/**
	 * Текущий контроллер.
	 *
	 * Так как вьюшки в большинстве случаев отрисовываются контроллерами, можно из вьюшки обратиться к контроллеру через $this->controller.
	 * В наследуемых классах достаточно прописать property-read в заголовке к классу, например:
	 * property-read SiteController $controller
	 * И тогда IDE определит, к какому контроллеру относится вьюшка.
	 *
	 * @var Controller
	 */
	public $controller;

	/**
	 * Функция, которая будет отрисовывать HTML содержимое.
	 * Фактически, это обычное noname-замыкание.
	 *
	 * @var callable
	 */
	protected $renderer;

	/**
	 * Конвертация класса в строку.
	 * Собственно, этот метод нужен, чтобы Yii без лишних "бубнов" подхватывал наш класс и отрисовывал его.
	 *
	 * @return string|null
	 *
	 * @author Zalatov Alexander <zalatov.ao@gmail.com>
	 */
	public function __toString(): ?string {
		// -- Захватываем буфер вывода
		ob_start();
		ob_implicit_flush(0);
		// -- -- -- --

		$this->controller = Yii::$app->controller;

		// -- Выполняем отрисовку
		$renderer = $this->renderer;
		try {
			$renderer();

			return ob_get_clean();// Отдаём данные из буфера и очищаем его
		}
		catch (Throwable $e) {
			Yii::$app->errorHandler->handleException($e);
		}
		// -- -- -- --

		return null;
	}
}
