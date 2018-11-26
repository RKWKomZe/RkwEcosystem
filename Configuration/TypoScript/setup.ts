plugin.tx_rkwecosystem {
	view {
		templateRootPaths.0 = EXT:rkw_ecosystem/Resources/Private/Templates/
		templateRootPaths.1 = {$plugin.tx_rkwecosystem.view.templateRootPath}
		partialRootPaths.0 = EXT:rkw_ecosystem/Resources/Private/Partials/
		partialRootPaths.1 = {$plugin.tx_rkwecosystem.view.partialRootPath}
		layoutRootPaths.0 = EXT:rkw_ecosystem/Resources/Private/Layouts/
		layoutRootPaths.1 = {$plugin.tx_rkwecosystem.view.layoutRootPath}
	}
	persistence {
		storagePid = {$plugin.tx_rkwecosystem.persistence.storagePid}
		#recursive = 1
	}
	features {
		#skipDefaultArguments = 1
	}
	mvc {
		#callDefaultActionIfActionCantBeResolved = 1
	}
	settings {
		pageTypeAjax = {$plugin.tx_rkwecosystem.settings.pageTypeAjax}
        pageTypePrint = {$plugin.tx_rkwecosystem.settings.pageTypePrint}
        loginPid = {$plugin.tx_rkwecosystem.settings.loginPid}
        xdlPid = {$plugin.tx_rkwecosystem.settings.xdlPid}
		ecosystemPid = {$plugin.tx_rkwecosystem.settings.ecosystemPid}
		myListPid = {$plugin.tx_rkwecosystem.settings.myListPid}
	}
}


# css
page.includeCSS {
    txRkwEcosystemFile10 = EXT:rkw_ecosystem/Resources/Public/Styles/introjs.css
    txRkwEcosystemFile20 = EXT:rkw_ecosystem/Resources/Public/Styles/main.css
}
# js
// Add jQuery
[globalVar = LIT:1 = {$plugin.tx_rkwecosystem.settings.includeJQuery}]
    page.includeJSFooterlibs.txRkwEcosystemJQuery  = EXT:rkw_ecosystem/Resources/Public/Js/jquery-3.1.1.min.js
[global]
[globalVar = TSFE:id={$plugin.tx_rkwecosystem.settings.ecosystemPid}]
    page.includeJSFooterlibs {
        txRkwEcosystemFile10 = EXT:rkw_ecosystem/Resources/Public/Scripts/intro.js
        txRkwEcosystemFile20 = EXT:rkw_ecosystem/Resources/Public/Scripts/main.js
    }
[global]



#===============================================================
# Ajax
#===============================================================
txRkwecosystemAjax = PAGE
txRkwecosystemAjax {

	typeNum = {$plugin.tx_rkwecosystem.settings.pageTypeAjax}

	config {
		disableAllHeaderCode = 1
		xhtml_cleaning = 0
		admPanel = 0
		additionalHeaders = Content-type: text/plain
		no_cache = 0
	}

	10 = USER_INT
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = RkwEcosystem
		pluginName = Ecosystem
		vendorName = RKW
		switchableControllerActions {

			# Again: Controller-Name and Action
			Ecosystem {
				10 = update
				20 = reset
				30 = persist
			}
		}

		view < plugin.tx_rkwecosystem.view
		persistence < plugin.tx_rkwecosystem.persistence
		settings < plugin.tx_rkwecosystem.settings
	}
}



#===============================================================
# PRINT
#===============================================================
txRkwEcosystemPrint = PAGE
txRkwEcosystemPrint {

	config {

		# Für Suche deaktivieren
		index_enable = 0
		index_metatags = 0
		index_externals = 0

		# delete page title
		noPageTitle = 1
	}

	# set new page title
	headerData = COA
	headerData {
		10 = TEXT
		10 {
			value  = Gründerökosystem Canvas - Druckansicht
			stdWrap.wrap = <title>|</title>
		}
	}

	# bodyTag
	bodyTag >
	bodyTagCObject = TEXT
	bodyTagCObject.value= print
	bodyTagCObject.wrap = <body class="|">

	# typenum
	typeNum = {$plugin.tx_rkwecosystem.settings.pageTypePrint}

	# styles
	stylesheet = EXT:rkw_ecosystem/Resources/Public/Styles/print.css

	# bootstrap userfunc
	10 = USER_INT
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = RkwEcosystem
		pluginName = Ecosystem
		vendorName = RKW
		switchableControllerActions {
			Ecosystem {
				10 = show
			}
		}

		view < plugin.tx_rkwecosystem.view
		persistence < plugin.tx_rkwecosystem.persistence
		settings < plugin.tx_rkwecosystem.settings
	}
}

