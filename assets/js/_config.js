import { Logger } from '@wlindabla/form_validator';
import { getMetaContent } from './_utils.js';

class Config {
  #params = null;

   param = (key) => {
    if (typeof key !== "string") { return null; }

    if (this.#params === null) {
        const raw = getMetaContent('iws-config');
        if (!raw) {
            Logger.warn('[SEO] meta iws-config introuvable ou vide.');
            this.#params = {}; // fallback vide
        } else {
            try {
                this.#params = JSON.parse(raw);
                Logger.log('[SEO] Config chargée:', this.#params);
            } catch (e) {
                Logger.error('[SEO] Erreur parsing JSON dans la meta iws-config:', e);
                this.#params = {}; // fallback vide
            }
        }
    }

    return key in this.#params ? this.#params[key] : null;
}

}

export default new Config();