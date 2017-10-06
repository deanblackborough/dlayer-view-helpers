<?php
declare(strict_types=1);

namespace Dlayer\ViewHelper;

use Zend\View\Helper\AbstractHelper;

/**
 * Generate the toolbar for the managers/designers
 *
 * @package Dlayer\ViewHelper
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Copyright (c) 2017 G3D Development Limited
 * @license https://github.com/Dlayer/dlayer-view-helpers/blob/master/LICENSE
 */
class Toolbar extends AbstractHelper
{
    /**
     * @var array Button groups by section
     */
    private $button_groups;

    /**
     * @var array Classes to apply to each button group
     */
    private $button_group_classes;

    /**
     * @var array Left button group
     */
    private $button_group_left;

    /**
     * Entry point for the view helper
     *
     * @return Toolbar
     */
    public function __invoke() : Toolbar
    {
        $this->reset();

        return $this;
    }

    /**
     * Pass in the button groups array
     *
     * @param array $groups The button groups to display
     *
     * @return Toolbar
     */
    public function buttonGroups(array $groups) : Toolbar
    {
        $this->button_groups = $groups;

        return $this;
    }

    /**
     * Custom classes to attach to button groups
     *
     * @param array $classes
     *
     * @return Toolbar
     */
    public function buttonGroupClasses(array $classes) : Toolbar
    {
        $this->button_group_classes = $classes;

        return $this;
    }

    /**
     * Set the button group to optionally display at the left edge of the toolbar, for Dlayer
     * this is typically the cancel button. Unlike the buttonGroup method this method assumes one
     * group, not multiple groups
     *
     * @param array $group The button group
     *
     * @return Toolbar
     */
    public function buttonGroupLeft($group) : Toolbar
    {
        $this->button_group_left = $group;
    }

    /**
     * Reset all properties in case the view helper is called multiple times within a script
     *
     * @return void
     */
    private function reset() : void
    {
        $this->button_groups = [];
        $this->button_group_classes = [];
        $this->button_group_left = [];
    }

    /**
     * Worker method for the view helper, generates the HTML, the method is private so that we
     * can echo/print the view helper directly
     *
     * @return string
     */
    private function render() : string
    {
        $html = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom mt5">';
        $html .= '
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarBottom" aria-controls="navbarBottom" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>';
        $html .= '
            <div class="collapse navbar-collapse" id="navbarBottom">';

        if (count($this->button_group_left) > 0) {
            $html .= '<div class="btn-group btn-group-sm">';
            foreach ($this->button_group_left as $button) {
                $html .= '<a class="btn btn-danger" href="' . $button['uri'] . '"><i class="fa fa-lg fa-ban" aria-hidden="true"></i>' . $button['name'] . '</a>';
            }
            $html .= '</div>';
        }

        foreach ($this->button_groups as $section) {
            foreach ($section as $group) {
                if (count($group) > 0) {
                    $html .= '<div class="btn-group ' . implode(' ', $this->button_group_classes) . '">';
                    foreach ($group as $button) {
                        $html .= '<a class="btn btn-outline-info" href="' . $button['uri'] . '">' . $button['name'] .
                            '</a>';
                    }
                    $html .= '</div>';
                }
            }
        }

        $html .= '
            <div class="btn-group ml-auto">
                <a class="btn btn-outline-info" href="#"><i class="fa fa-lg fa-expand" aria-hidden="true"></i></a>
            </div></div>';
        $html .= '</nav>';

        return $html;
    }

    /**
     * Override the __toString() method to allow echo/print of the view helper directly, saves a
     * call to render()
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->render();
    }
}
