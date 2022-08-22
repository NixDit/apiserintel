<?php
/** Set active class */
function setActive($routeName){
    return request()->routeIs( $routeName ) ? 'active' : '';
}
/** Set open class */
function setOpen( $parentRoute ) {
    return request()->routeIs( $parentRoute . '.*' ) ? 'here show' : '';
}