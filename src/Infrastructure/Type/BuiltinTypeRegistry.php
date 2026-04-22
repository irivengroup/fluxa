<?php

declare(strict_types=1);

namespace Iriven\Fluxa\Infrastructure\Type;

final class BuiltinTypeRegistry
{
    /**
     * @return array<string, string>
     */
    public static function fieldTypes(): array
    {
        return [
            'AudioType' => \Iriven\Fluxa\Domain\Field\AudioType::class,
            'ButtonType' => \Iriven\Fluxa\Domain\Field\ButtonType::class,
            'CaptchaType' => \Iriven\Fluxa\Domain\Field\CaptchaType::class,
            'CheckboxType' => \Iriven\Fluxa\Domain\Field\CheckboxType::class,
            'CollectionType' => \Iriven\Fluxa\Domain\Field\CollectionType::class,
            'ColorType' => \Iriven\Fluxa\Domain\Field\ColorType::class,
            'CountryType' => \Iriven\Fluxa\Domain\Field\CountryType::class,
            'DatalistType' => \Iriven\Fluxa\Domain\Field\DatalistType::class,
            'DateType' => \Iriven\Fluxa\Domain\Field\DateType::class,
            'DatetimeLocalType' => \Iriven\Fluxa\Domain\Field\DatetimeLocalType::class,
            'DatetimeType' => \Iriven\Fluxa\Domain\Field\DatetimeType::class,
            'EditorType' => \Iriven\Fluxa\Domain\Field\EditorType::class,
            'EmailType' => \Iriven\Fluxa\Domain\Field\EmailType::class,
            'FileType' => \Iriven\Fluxa\Domain\Field\FileType::class,
            'FloatType' => \Iriven\Fluxa\Domain\Field\FloatType::class,
            'HiddenType' => \Iriven\Fluxa\Domain\Field\HiddenType::class,
            'ImageType' => \Iriven\Fluxa\Domain\Field\ImageType::class,
            'IntegerType' => \Iriven\Fluxa\Domain\Field\IntegerType::class,
            'MonthType' => \Iriven\Fluxa\Domain\Field\MonthType::class,
            'NumberType' => \Iriven\Fluxa\Domain\Field\NumberType::class,
            'PasswordType' => \Iriven\Fluxa\Domain\Field\PasswordType::class,
            'PhoneType' => \Iriven\Fluxa\Domain\Field\PhoneType::class,
            'RadioType' => \Iriven\Fluxa\Domain\Field\RadioType::class,
            'RangeType' => \Iriven\Fluxa\Domain\Field\RangeType::class,
            'ResetType' => \Iriven\Fluxa\Domain\Field\ResetType::class,
            'SearchType' => \Iriven\Fluxa\Domain\Field\SearchType::class,
            'SelectType' => \Iriven\Fluxa\Domain\Field\SelectType::class,
            'SubmitType' => \Iriven\Fluxa\Domain\Field\SubmitType::class,
            'TextareaType' => \Iriven\Fluxa\Domain\Field\TextareaType::class,
            'TextType' => \Iriven\Fluxa\Domain\Field\TextType::class,
            'TimeType' => \Iriven\Fluxa\Domain\Field\TimeType::class,
            'UrlType' => \Iriven\Fluxa\Domain\Field\UrlType::class,
            'VideoType' => \Iriven\Fluxa\Domain\Field\VideoType::class,
            'WeekType' => \Iriven\Fluxa\Domain\Field\WeekType::class,
            'YesNoType' => \Iriven\Fluxa\Domain\Field\YesNoType::class,
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function formTypes(): array
    {
        return [
            'ContactType' => \Iriven\Fluxa\Application\FormType\ContactType::class,
            'CustomerType' => \Iriven\Fluxa\Application\FormType\CustomerType::class,
            'ForgotPasswordType' => \Iriven\Fluxa\Application\FormType\ForgotPasswordType::class,
            'LoginType' => \Iriven\Fluxa\Application\FormType\LoginType::class,
            'InvoiceLineType' => \Iriven\Fluxa\Application\FormType\InvoiceLineType::class,
            'InvoiceType' => \Iriven\Fluxa\Application\FormType\InvoiceType::class,
            'RegistrationType' => \Iriven\Fluxa\Application\FormType\RegistrationType::class,
            'ResetPasswordType' => \Iriven\Fluxa\Application\FormType\ResetPasswordType::class,
        ];
    }
}
