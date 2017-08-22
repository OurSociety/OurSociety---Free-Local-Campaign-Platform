// Vendor scripts
import Popper from 'popper.js'
import 'bootstrap'

// Attach to DOM
window.Popper = Popper

// Load custom JS
import './analytics/dashboard'
import './charts/categories'
import './keen.io/cohorts'
// import './charts/votes'

// Bundle images
import '../../img/logo/logo.svg'
