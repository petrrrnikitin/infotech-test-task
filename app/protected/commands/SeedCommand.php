<?php

class SeedCommand extends CConsoleCommand
{
    public function getHelp(): string
    {
        return <<<EOD
USAGE
  yiic seed

DESCRIPTION
  Заполняет базу данных тестовыми данными:
  - 10 авторов
  - 100 книг (у каждой книги 1-3 автора)

EOD;
    }

    public function actionIndex(): void
    {
        echo "Начинаю заполнение базы данных...\n\n";

        $this->seedAuthors();
        $this->seedBooks();

        echo "\nГотово!\n";
    }

    private function seedAuthors(): void
    {
        echo "Создаю авторов...\n";

        $authors = [
            ['first_name' => 'Лев', 'last_name' => 'Толстой', 'middle_name' => 'Николаевич'],
            ['first_name' => 'Фёдор', 'last_name' => 'Достоевский', 'middle_name' => 'Михайлович'],
            ['first_name' => 'Антон', 'last_name' => 'Чехов', 'middle_name' => 'Павлович'],
            ['first_name' => 'Александр', 'last_name' => 'Пушкин', 'middle_name' => 'Сергеевич'],
            ['first_name' => 'Михаил', 'last_name' => 'Булгаков', 'middle_name' => 'Афанасьевич'],
            ['first_name' => 'Николай', 'last_name' => 'Гоголь', 'middle_name' => 'Васильевич'],
            ['first_name' => 'Иван', 'last_name' => 'Тургенев', 'middle_name' => 'Сергеевич'],
            ['first_name' => 'Борис', 'last_name' => 'Пастернак', 'middle_name' => 'Леонидович'],
            ['first_name' => 'Максим', 'last_name' => 'Горький', 'middle_name' => ''],
            ['first_name' => 'Владимир', 'last_name' => 'Набоков', 'middle_name' => 'Владимирович'],
        ];

        foreach ($authors as $data) {
            $author = new Author();
            $author->first_name = $data['first_name'];
            $author->last_name = $data['last_name'];
            $author->middle_name = $data['middle_name'];

            if ($author->save()) {
                echo "  + {$data['last_name']} {$data['first_name']}\n";
            } else {
                echo "  ! Ошибка: " . implode(', ', $author->getErrors()) . "\n";
            }
        }

        echo "Создано авторов: " . Author::model()->count() . "\n";
    }

    private function seedBooks(): void
    {
        echo "\nСоздаю книги...\n";

        $titles = [
            'Война и мир', 'Анна Каренина', 'Воскресение', 'Казаки',
            'Преступление и наказание', 'Идиот', 'Братья Карамазовы', 'Бесы',
            'Вишнёвый сад', 'Чайка', 'Три сестры', 'Дядя Ваня',
            'Евгений Онегин', 'Капитанская дочка', 'Пиковая дама', 'Дубровский',
            'Мастер и Маргарита', 'Собачье сердце', 'Белая гвардия', 'Морфий',
            'Мёртвые души', 'Ревизор', 'Тарас Бульба', 'Шинель',
            'Отцы и дети', 'Дворянское гнездо', 'Накануне', 'Рудин',
            'Доктор Живаго', 'Детство Люверс', 'Охранная грамота', 'Воздушные пути',
            'На дне', 'Мать', 'Детство', 'В людях',
            'Лолита', 'Защита Лужина', 'Приглашение на казнь', 'Дар',
        ];

        $adjectives = ['Новый', 'Старый', 'Большой', 'Малый', 'Тайный', 'Забытый', 'Последний', 'Первый'];
        $nouns = ['путь', 'день', 'свет', 'мир', 'город', 'дом', 'сон', 'час', 'век', 'край'];

        $authorIds = Yii::app()->db->createCommand('SELECT id FROM authors')->queryColumn();

        for ($i = 1; $i <= 100; $i++) {
            $book = new Book();

            if ($i <= count($titles)) {
                $book->title = $titles[$i - 1];
            } else {
                $book->title = $adjectives[array_rand($adjectives)] . ' ' . $nouns[array_rand($nouns)] . ' ' . $i;
            }

            $book->year = random_int(1850, 2024);
            $book->description = $this->generateDescription();
            $book->isbn = $this->generateIsbn();
            $book->created_at = date('Y-m-d H:i:s');
            $book->updated_at = date('Y-m-d H:i:s');

            if ($book->save()) {
                $numAuthors = random_int(1, 3);
                $bookAuthors = array_rand(array_flip($authorIds), $numAuthors);
                if (!is_array($bookAuthors)) {
                    $bookAuthors = [$bookAuthors];
                }

                foreach ($bookAuthors as $authorId) {
                    Yii::app()->db->createCommand()->insert('book_authors', [
                        'book_id' => $book->id,
                        'author_id' => $authorId,
                    ]);
                }

                echo "  + [{$i}/100] {$book->title}\n";
            } else {
                echo "  ! Ошибка книги {$i}: " . print_r($book->getErrors(), true) . "\n";
            }
        }

        echo "Создано книг: " . Book::model()->count() . "\n";
    }

    private function generateDescription(): string
    {
        $sentences = [
            'Увлекательная история о поиске смысла жизни.',
            'Роман о любви и предательстве.',
            'Философские размышления о судьбе человека.',
            'Захватывающий сюжет не оставит равнодушным.',
            'Классика русской литературы.',
            'Произведение, вошедшее в золотой фонд мировой литературы.',
            'История о сложных человеческих отношениях.',
            'Глубокий психологический анализ личности.',
        ];

        $count = random_int(2, 4);
        $selected = array_rand(array_flip($sentences), $count);
        if (!is_array($selected)) {
            $selected = [$selected];
        }

        return implode(' ', $selected);
    }

    private function generateIsbn(): string
    {
        return sprintf(
            '978-%d-%d-%d-%d',
            random_int(0, 9),
            random_int(10000, 99999),
            random_int(100, 999),
            random_int(0, 9)
        );
    }
}
