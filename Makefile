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
	echo 'Extension can be found in $(BUILD_ROOT)'

build: build-pdf-docs build-extension
	mkdir $(BUILD_DOCS_ROOT)
	cp -rf ./docs/build/pdf/* $(BUILD_DOCS_ROOT)

build-zip: build
	# Create a zip for online distribution. Use Python stdlib zip to limit dependency requirements.
	$(PYTHON) -c "import shutil; shutil.make_archive('$(BUILD_ROOT)', 'zip', '$(BUILD_ROOT)')"

