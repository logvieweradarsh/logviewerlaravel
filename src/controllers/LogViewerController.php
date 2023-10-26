<?php

namespace LogViewerLaravel;

use ViewerLogic\ViewerLogic;
use Illuminate\Http\Request;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Crypt;

if (class_exists("\\Illuminate\\Routing\\Controller")) {	
    class BaseController extends \Illuminate\Routing\Controller {}	
} elseif (class_exists("Laravel\\Lumen\\Routing\\Controller")) {	
    class BaseController extends \Laravel\Lumen\Routing\Controller {}	
}

/**
 * Class LogViewerController
 * @package LogViewerLaravel
 */
class LogViewerController extends BaseController
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var LogViewerLaravel
     */
    private $log_viewer;
    public $modifyTime = [];
    /**
     * @var string
     */
    protected $view_log = 'log-viewer-laravel::log';
    protected $view_log_view = 'log-viewer-laravel::log_view';

    /**
     * LogViewerController constructor.
     */
    public function __construct()
    {
        $this->log_viewer = new ViewerLogic();
        $this->request = app('request');
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function index()
    {
        try{

            $folderFiles = [];
            if ($this->request->input('f')) {
            $this->log_viewer->setFolder(Crypt::decrypt($this->request->input('f')));
            $folderFiles = $this->log_viewer->getFolderFiles(true);
            }
            if ($this->request->input('l')) {
                $this->log_viewer->setFile(Crypt::decrypt($this->request->input('l')));
            }

            if ($early_return = $this->earlyReturn()) {
                return $early_return;
            }

            $data = [
                'logs' => '',
                'folders' => $this->log_viewer->getFolders(),
                'current_folder' => $this->log_viewer->getFolderName(),
                'folder_files' => $folderFiles,
                'files' => $this->log_viewer->getFiles(true),
                'current_file' => $this->log_viewer->getFileName(),
                'standardFormat' => true,
                'structure' => $this->log_viewer->foldersAndFiles(),
                'storage_path' => $this->log_viewer->getStoragePath(),

            ];
            
            if ($this->request->wantsJson()) {
                return $data;
            }

            return app('view')->make($this->view_log, $data);
        }catch(\Exception $e) {
            return $e;
        }
    }

    public function view(Request $request)
    {
        try{

            $path = $request->l;
            $folderFiles = [];
            if ($this->request->input('f')) {
                $this->log_viewer->setFolder(Crypt::decrypt($this->request->input('f')));
                $folderFiles = $this->log_viewer->getFolderFiles(true);
            }
            if ($this->request->input('l')) {
                $this->log_viewer->setFile(Crypt::decrypt($this->request->input('l')));
            }

            if ($early_return = $this->earlyReturn()) {
                return $early_return;
            }
            
            try{
                
                $data = [
                    'logs' => $this->log_viewer->all(),
                    'folders' => $this->log_viewer->getFolders(),
                    'current_folder' => '',
                    'folder_files' => $folderFiles,
                    'files' => $this->log_viewer->getFiles(true),
                    'path' => $path,
                    'current_file' => $this->log_viewer->getFileName(),
                    'standardFormat' => true,
                    'structure' => $this->log_viewer->foldersAndFiles(),
                    'storage_path' => $this->log_viewer->getStoragePath(),       
                ];

                // dd($data);
            }catch(\Exception $e) {
                return $e;
            }

            return app('view')->make($this->view_log_view, $data);
        }catch(\Exception $e) {
            dd($e);
        }
    }


    /**
     * @return bool|mixed
     * @throws \Exception
     */
    private function earlyReturn()
    {
        if ($this->request->input('f')) {
            $this->log_viewer->setFolder(Crypt::decrypt($this->request->input('f')));
        }

        if ($this->request->input('dl')) {
            return $this->download($this->pathFromInput('dl'));
        } elseif ($this->request->has('clean')) {
            app('files')->put($this->pathFromInput('clean'), '');
            return $this->redirect(url()->previous());
        } elseif ($this->request->has('del')) {
            app('files')->delete($this->pathFromInput('del'));
            return redirect()->route('log.viewer');
        } 
        // elseif ($this->request->has('delall')) {
        //     $files = ($this->log_viewer->getFolderName())
        //                 ? $this->log_viewer->getFolderFiles(true)
        //                 : $this->log_viewer->getFiles(true);
        //     foreach ($files as $file) {
        //         app('files')->delete($this->log_viewer->pathToLogFile($file));
        //     }
        //     return $this->redirect($this->request->url());
        // }
        return false;
    }

    /**
     * @param string $input_string
     * @return string
     * @throws \Exception
     */
    private function pathFromInput($input_string)
    {
        return $this->log_viewer->pathToLogFile(Crypt::decrypt($this->request->input($input_string)));
    }

    /**
     * @param $to
     * @return mixed
     */
    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }

        return app('redirect')->to($to);
    }

    /**
     * @param string $data
     * @return mixed
     */
    private function download($data)
    {
        if (function_exists('response')) {
            return response()->download($data);
        }

        // For laravel 4.2
        return app('\Illuminate\Support\Facades\Response')->download($data);
    }
}
