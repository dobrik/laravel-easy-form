<?php

namespace Dobrik\LaravelEasyForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TranslationsAbstract for translations.
 * @package App\Models
 */
abstract class TranslatableModelAbstract extends Model
{
    /**
     * Translatable fields.
     *
     * @var array
     */
    public $translatable = [];

    /**
     * Current locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * Request
     * @var array
     */
    protected $request_translations = [];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        self::saved(function ($model) {
            $model->saveTranslations();
        });

        parent::boot();
    }

    /**
     * Fill model
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (\in_array($key, $this->translatable, true)) {
                $this->request_translations[$key] = $value;
            }
        }
        return parent::fill($attributes);
    }

    /**
     * Save translations for current entity
     *
     * @return void
     */
    public function saveTranslations(): void
    {
        if (!$this->request_translations) {
            return;
        }
        $isUpdated = false;
        foreach (config('app.locales') as $locale) {
            $_data = [];
            foreach ($this->request_translations as $attr => $translations) {
                $_data[$attr] = $translations[$locale];
            }

            $translationModel = $this->translations()->updateOrCreate(
                [
                    'locale' => $locale,
                    $this->translations()->getForeignKeyName() => $this->id
                ],
                $_data
            );
            if ($translationModel->wasChanged()) {
                $isUpdated = true;
            }
        }
        if ($isUpdated === true) {
            $this->fireModelEvent('updated');
        }
    }

    /**
     * Get relations for entities
     *
     * @return HasMany
     */
    abstract public function translations(): HasMany;

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (\in_array($key, $this->translatable, true) && null === $value) {
            $translations = $this->getRequestTranslations();
            return null !== $translations ? $this->getRequestTranslations()->{$key} : null;
        }

        return $value;
    }

    /**
     * Get the translations for current entity
     *
     * @param string|null $locale Current locale.
     * @return mixed
     */
    public function getRequestTranslations(string $locale = null)
    {
        $locale = $locale ?? $this->locale ?? app()->getLocale();

        if (!isset($this->request_translations[$locale])) {
            $this->request_translations[$locale] = $this->translations
                ->where('locale', $locale)->first();
        }
        return $this->request_translations[$locale];
    }

    /**
     * Set locale.
     * @param string $locale Current locale code.
     *
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * Get translated attribute
     * @param string $locale    Current locale.
     * @param string $attribute Attribute for translation.
     * @return string|null
     */
    public function getLocalizedAttribute(string $locale, string $attribute): ?string
    {
        $translations = $this->getRequestTranslations($locale);
        return $translations ? $translations->{$attribute} : null;
    }
}
