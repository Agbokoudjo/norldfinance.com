/*!
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import { Logger } from '@wlindabla/form_validator';
import { getMetaContent } from './_utils.js';

class Translation {
  #messages = null;

  trans(key) {
    if (typeof key !== "string") { return null; }
    if (this.#messages === null) {
      const raw_messages = getMetaContent('iws-translations');
      if (!raw_messages) {
        Logger.warn('[SEO] meta iws-translations introuvable ou vide.');
        this.#messages = {}; // fallback vide
    } else {
        try {
            this.#messages = JSON.parse(raw_messages);
            Logger.log('[SEO] Translation chargée:', this.#messages);
        } catch (e) {
            Logger.error('[SEO] Erreur parsing JSON dans la meta iws-translations:', e);
            this.#messages = {}; // fallback vide
        }
    }
    }

    return key in this.#messages ? this.#messages[key]: null;
  }
}

export default new Translation();
