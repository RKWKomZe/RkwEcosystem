
plugin.tx_rkwecosystem {
	view {
		# cat=plugin.tx_rkwecosystem_ecosystem/file; type=string; label=Path to template root (FE)
		templateRootPath = EXT:rkw_ecosystem/Resources/Private/Templates/
		# cat=plugin.tx_rkwecosystem_ecosystem/file; type=string; label=Path to template partials (FE)
		partialRootPath = EXT:rkw_ecosystem/Resources/Private/Partials/
		# cat=plugin.tx_rkwecosystem_ecosystem/file; type=string; label=Path to template layouts (FE)
		layoutRootPath = EXT:rkw_ecosystem/Resources/Private/Layouts/
	}
	persistence {
		# cat=plugin.tx_rkwecosystem_ecosystem//a; type=string; label=Default storage PID
		storagePid =
	}
	settings {

        # cat=plugin.tx_rkwecosystem//a; type=boolean; label=Include jQueryLib (default: 0)
        includeJQuery = 0

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=Page Type for AJAX
		pageTypeAjax = 1513597215

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=Page Type for Print View
        pageTypePrint = 1513597216

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=Login PID
        loginPid =

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=XDL Login PID
        xdlPid =

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=PID of Ecosystem Plugin
        ecosystemPid =

        # cat=plugin.tx_rkwecosystem//a; type=integer; label=PID of Ecosystem MyList- Plugin
        myListPid =
	}
}
