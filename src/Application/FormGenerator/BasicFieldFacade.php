<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Application\FormGenerator;

use Iriven\Fluxa\Domain\Field\AudioType;
use Iriven\Fluxa\Domain\Field\ButtonType;
use Iriven\Fluxa\Domain\Field\CaptchaType;
use Iriven\Fluxa\Domain\Field\CollectionType;
use Iriven\Fluxa\Domain\Field\ColorType;
use Iriven\Fluxa\Domain\Field\CountryType;
use Iriven\Fluxa\Domain\Field\DateType;
use Iriven\Fluxa\Domain\Field\DatetimeLocalType;
use Iriven\Fluxa\Domain\Field\DatetimeType;
use Iriven\Fluxa\Domain\Field\EditorType;
use Iriven\Fluxa\Domain\Field\EmailType;
use Iriven\Fluxa\Domain\Field\FileType;
use Iriven\Fluxa\Domain\Field\FloatType;
use Iriven\Fluxa\Domain\Field\HiddenType;
use Iriven\Fluxa\Domain\Field\ImageType;
use Iriven\Fluxa\Domain\Field\IntegerType;
use Iriven\Fluxa\Domain\Field\MonthType;
use Iriven\Fluxa\Domain\Field\NumberType;
use Iriven\Fluxa\Domain\Field\PasswordType;
use Iriven\Fluxa\Domain\Field\PhoneType;
use Iriven\Fluxa\Domain\Field\RangeType;
use Iriven\Fluxa\Domain\Field\ResetType;
use Iriven\Fluxa\Domain\Field\SearchType;
use Iriven\Fluxa\Domain\Field\SubmitType;
use Iriven\Fluxa\Domain\Field\TextareaType;
use Iriven\Fluxa\Domain\Field\TextType;
use Iriven\Fluxa\Domain\Field\TimeType;
use Iriven\Fluxa\Domain\Field\UrlType;
use Iriven\Fluxa\Domain\Field\VideoType;
use Iriven\Fluxa\Domain\Field\WeekType;
use Iriven\Fluxa\Domain\Form\FormBuilder;

final class BasicFieldFacade
{
    public function __construct(
        private readonly FormBuilder $builder,
        private readonly AttributeNormalizer $normalizer,
    ) {
    }

    /** @param array<string, mixed> $attributes */
    public function add(string $name, string $typeClass, array $attributes = []): void
    {
        $this->builder->add($name, $typeClass, $this->normalizer->normalize($attributes));
    }

    /** @param array<string, mixed> $attributes */
    public function addText(string $name, array $attributes = []): void { $this->add($name, TextType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addEmail(string $name, array $attributes = []): void { $this->add($name, EmailType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addTextarea(string $name, array $attributes = []): void { $this->add($name, TextareaType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addEditor(string $name, array $attributes = []): void { $this->add($name, EditorType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addHidden(string $name, array $attributes = []): void { $this->add($name, HiddenType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addSubmit(string $name, array $attributes = []): void { $this->add($name, SubmitType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addButton(string $name, array $attributes = []): void { $this->add($name, ButtonType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addReset(string $name, array $attributes = []): void { $this->add($name, ResetType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addFile(string $name, array $attributes = []): void { $this->add($name, FileType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addAudio(string $name, array $attributes = []): void { $this->add($name, AudioType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addImage(string $name, array $attributes = []): void { $this->add($name, ImageType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addVideo(string $name, array $attributes = []): void { $this->add($name, VideoType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addCountries(string $name, array $attributes = []): void { $this->add($name, CountryType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addCountry(string $name, array $attributes = []): void { $this->addCountries($name, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addDatetime(string $name, array $attributes = []): void { $this->add($name, DatetimeType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addDatetimeLocal(string $name, array $attributes = []): void { $this->add($name, DatetimeLocalType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addDate(string $name, array $attributes = []): void { $this->add($name, DateType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addTime(string $name, array $attributes = []): void { $this->add($name, TimeType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addMonth(string $name, array $attributes = []): void { $this->add($name, MonthType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addWeek(string $name, array $attributes = []): void { $this->add($name, WeekType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addInteger(string $name, array $attributes = []): void { $this->add($name, IntegerType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addFloat(string $name, array $attributes = []): void { $this->add($name, FloatType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addNumber(string $name, array $attributes = []): void { $this->add($name, NumberType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addRange(string $name, array $attributes = []): void { $this->add($name, RangeType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addColor(string $name, array $attributes = []): void { $this->add($name, ColorType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addPassword(string $name, array $attributes = []): void { $this->add($name, PasswordType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addPhone(string $name, array $attributes = []): void { $this->add($name, PhoneType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addSearch(string $name, array $attributes = []): void { $this->add($name, SearchType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addUrl(string $name, array $attributes = []): void { $this->add($name, UrlType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addCaptcha(string $name, array $attributes = []): void { $this->add($name, CaptchaType::class, $attributes); }
    /** @param array<string, mixed> $attributes */
    public function addCollection(string $name, array $attributes = []): void { $this->add($name, CollectionType::class, $attributes); }
}
