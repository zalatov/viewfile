## Базовый класс для файлов шаблонов / вьюшек

Основная идея - использовать именно классы для отрисовки вьюшек.  
В чём плюсы:
1) Использование Find Usages в IDE
2) Указание и нативная проверка обязательных параметров
3) phpdoc (описание) для параметров
4) Использование разделения и поиска вьюшек через namespace’ы

### Пример использования

```php
<?php

declare(strict_types=1);

use yii\helpers\Html;
use zalatov\viewfile\ViewFile;

/**
 * Главная страница.
 *
 * @property-read SiteController $controller Контроллер
 *
 * @author Zalatov Alexander <zalatov.ao@gmail.com>
 */
class Index_ViewFile extends ViewFile {
	/**
	 * @param string $url   Какая-то ссылка
	 * @param int    $count Какое-то количество
	 *
	 * @author Zalatov Alexander <zalatov.ao@gmail.com>
	 */
	public function __construct(string $url, int $count) {
		$this->renderer = function() use ($url, $count) {
?>

<?# Тут идёт любой код ?>
<?= Html::a($url, 'Список пунктов [' . $count . ']') ?>

<?};}}
```
