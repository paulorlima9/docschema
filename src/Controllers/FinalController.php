<?php

namespace DocSchema\Controllers;

use Illuminate\Routing\Controller;
use DocSchema\Events\LaravelInstallerFinished;
use DocSchema\Helpers\EnvironmentManager;
use DocSchema\Helpers\FinalInstallManager;
use DocSchema\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \DocSchema\Helpers\InstalledFileManager $fileManager
     * @param \DocSchema\Helpers\FinalInstallManager $finalInstall
     * @param \DocSchema\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent(); 
        event(new LaravelInstallerFinished);
        return view('pdo::finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
