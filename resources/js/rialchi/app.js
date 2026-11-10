import { initDisclosures } from "./modules/disclosures.js";
import { initNavigation } from './modules/navigation.js';
import { initMotion } from './modules/motion.js';
import { initJourney } from './modules/journey.js';
import { initContact } from './modules/contact.js';
import { initTracking } from './modules/tracking.js';

// Every initializer safely handles pages without its corresponding elements.
initNavigation();
initMotion();
initJourney();
initDisclosures();
initContact();
initTracking();

import { initPort } from './modules/port.js';
initPort();
