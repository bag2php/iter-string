# Makefile for PHP Project
#
# Copyright (c) 2019  USAMI Kenta
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in all
# copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.
#
# License: MIT

PHP ?= php
COMPOSER = tools/composer.phar
AUTOLOAD_PHP = vendor/autoload.php
RM = rm -f
APP_ENV =

.DEFAULT_GOAL := $(AUTOLOAD_PHP)

$(COMPOSER):
	tools/setup-composer

composer.lock: $(COMPOSER) composer.json
	$(PHP) $(COMPOSER) install --no-progress

$(AUTOLOAD_PHP): composer.lock

tools/.phan/vendor/bin/phan:
	$(PHP) $(COMPOSER) install -d tools/.phan

tools/.php-cs-fixer/vendor/bin/php-cs-fixer:
	$(PHP) $(COMPOSER) install -d tools/.php-cs-fixer

tools/.phpdocumentor/vendor/bin/phpdoc:
	-$(RM) tools/.phpdocumentor/composer.lock # workaround
	$(PHP) $(COMPOSER) install -d tools/.phpdocumentor

tools/.phpstan/vendor/bin/phpstan:
	$(PHP) $(COMPOSER) install -d tools/.phpstan

tools/.psalm/vendor/bin/psalm:
	$(PHP) $(COMPOSER) install -d tools/.psalm

tools/deptrac: tools/.deptrac/vendor/bin/deptrac
	(cd tools; ln -sf .deptrac/vendor/bin/deptrac .)

tools/phan: tools/.phan/vendor/bin/phan
	(cd tools; ln -sf .phan/vendor/bin/phan .)

tools/php-cs-fixer: tools/.php-cs-fixer/vendor/bin/php-cs-fixer
	(cd tools; ln -sf .php-cs-fixer/vendor/bin/php-cs-fixer .)

tools/phpdoc: tools/.phpdocumentor/vendor/bin/phpdoc
	(cd tools; ln -sf .phpdocumentor/vendor/bin/phpdoc .)

tools/phpstan: tools/.phpstan/vendor/bin/phpstan
	(cd tools; ln -sf .phpstan/vendor/bin/phpstan .)

tools/psalm: tools/.psalm/vendor/bin/psalm
	(cd tools; ln -sf .psalm/vendor/bin/psalm .)

.PHONY: analyse composer composer-no-dev clean clobber deptrac doc fix phan phpdoc phpstan-no-dev phpstan psalm setup setup-tools test

analyse-no-dev: phan phpstan-no-dev psalm-no-dev
analyse: phan phpstan psalm deptrac

composer: $(AUTOLOAD_PHP)

composer-no-dev:
	$(PHP) $(COMPOSER) install --no-dev --optimize-autoloader --no-progress

clobber: clean
	-$(RM) tools/*.phar tools/phan tools/php-cs-fixer tools/phpstan tools/psalm
	-$(RM) -r tools/.phan/composer.lock tools/.phan/vendor
	-$(RM) -r tools/.php-cs-fixer/composer.lock tools/.php-cs-fixer/vendor
	-$(RM) -r tools/.phpdocumentor/composer.lock tools/.phpdocumentor/vendor
	-$(RM) -r tools/.phpstan/composer.lock tools/.phpstan/vendor
	-$(RM) -r tools/.psalm/composer.lock tools/.psalm/vendor
	-$(RM) -r vendor
	-$(RM) composer.lock

clean:
	-$(RM) -r build
	-$(RM) .php_cs.cache

deptrac: tools/deptrac
	-$(PHP) tools/deptrac

doc: phpdoc

fix: tools/php-cs-fixer
	$(PHP) tools/php-cs-fixer fix

phan: tools/phan
	-$(PHP) tools/phan

phpdoc: tools/phpdoc
	APP_ENV=$(APP_ENV) $(PHP) tools/phpdoc

phpstan-no-dev: tools/phpstan
	-$(PHP) tools/phpstan analyse src/ --no-progress

phpstan: tools/phpstan
	-$(PHP) tools/phpstan analyse --no-progress

psalm-no-dev: tools/psalm
	-$(PHP) tools/psalm src/

psalm: tools/psalm
	-$(PHP) tools/psalm

setup: $(COMPOSER)

setup-doc: setup tools/phpdoc

setup-tools: setup tools/php-cs-fixer tools/phan tools/phpstan tools/psalm

test: vendor/bin/phpunit
	$(PHP) vendor/bin/phpunit
