PYTHON = python

RELEASE_VERSION := $(shell $(PYTHON) -c "from helper import RELEASE_VERSION; print(RELEASE_VERSION);")

BUILD_ROOT = "dist/SendCloud-OpenCart-2-Extension-$(RELEASE_VERSION)"
BUILD_SENDCLOUD_ROOT = $(BUILD_ROOT)/upload/system/sendcloud
BUILD_DOCS_ROOT = $(BUILD_ROOT)/docs/

usage:
	echo 'Usage: make build'

build-pdf-docs:
	cd docs && make clean && make pdf
	echo 'PDF docs can be found in docs/build/pdf/'

build-extension:
	rm -rf ./dist/
	mkdir -p $(BUILD_SENDCLOUD_ROOT)

	cp -r ./src/admin ./src/catalog ./src/image ./src/vqmod ./src/system $(BUILD_ROOT)/upload/
	curl https://raw.githubusercontent.com/SendCloud/SendCloud-API-PHP-Wrapper/a40dfd55acfea2d33301169c63d59c82a68b47f4/src/SendCloudApi.php \
		> "$(BUILD_SENDCLOUD_ROOT)/sendcloud_api.php"
    mv $(BUILD_ROOT)/upload/vqmod/xml/comercia_util.xml $(BUILD_ROOT)/upload/vqmod/xml/comercia.xml
    # Just in case the user had a comercia_util.xml on his server, we replace it with an empty one. This can be removed in the future.
    touch $(BUILD_ROOT)/upload/vqmod/xml/comercia_util.xml
	echo 'Extension can be found in $(BUILD_ROOT)'

build: build-pdf-docs build-extension
	mkdir $(BUILD_DOCS_ROOT)
	cp -rf ./docs/build/pdf/* $(BUILD_DOCS_ROOT)

build-zip: build
	# Create a zip for online distribution. Use Python stdlib zip to limit dependency requirements.
	$(PYTHON) -c "import shutil; shutil.make_archive('$(BUILD_ROOT)', 'zip', '$(BUILD_ROOT)')"

