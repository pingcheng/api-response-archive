<?php
/**
 * Created by PhpStorm.
 * User: pingcheng
 * Date: 3/4/18
 * Time: 10:59 PM
 */

namespace PingCheng\ApiResponse\Traits;

trait statusShortcuts {
    private function statusShortcut_applydata($data = null) {
        if (!is_null($data)) {
            $this->data($data);
        }
    }

    public function success($data = null) {
        $this->code(200);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function created($data = null) {
        $this->code(201);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function error($data = null) {
        $this->code(400);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function unauthorized($data = null) {
        $this->code(401);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function forbidden($data = null) {
        $this->code(403);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function notfound($data = null) {
        $this->code(404);
        $this->statusShortcut_applydata($data);
        return $this;
    }

    public function fatal($data = null) {
        $this->code(500);
        $this->statusShortcut_applydata($data);
        return $this;
    }
}