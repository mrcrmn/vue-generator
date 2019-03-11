# Vue Generator

<img src="https://mrcrmn.github.io/vue-generator_logo.png" width="200">

Clean up your PHP templates and create simple data objects to render your Vue components and its props.

Never do the following ever again.
```php
<v-slider :autoplay="<?php echo ($shouldAutoplay ? 'true' : 'false'); ?>">
    <?php foreach ($sliderItems as $item): ?>
        <v-slider-item src="<?php echo $item['src']; ?>"></v-slider-item>
    <?php endforeach; ?>
</v-slider>
```
Instead, do this.
```php
use mrcrmn\VueGenerator\Vue;
use mrcrmn\VueGenerator\VueCollection;

$slider = Vue::make('v-slider')->setProp('autoplay', true);

$slider->setSlot(new VueCollection([
    Vue::make('v-slider-item')->setProp('src', 'image1.jpg'),
    Vue::make('v-slider-item')->setProp('src', 'image2.jpg'),
]));
```
And then in your template.
```php
<?php echo $slider; ?>
```

## Installation

### Composer
To install this package run the following command in your project's root.
```bash
$ composer require mrcrmn/vue-generator
```

## Docs
For the docs visit (https://mrcrmn.github.io/packages/vue-generator/)
