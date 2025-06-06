import { Logger } from '@wlindabla/form_validator';
import { getMetaContent } from './_utils.js';

class Config {
  #params = null;

    /**
     * 
     * @param {string} key 
     * @returns any|null
     */
    param = (key) => {
        if (typeof key !== "string") { return null; }
        if (this.#params === null) {
          this.#params = JSON.parse(getMetaContent('iws-config'));
          Logger.log(this.#params)
        }
        if (key in this.#params) {return this.#params[key];}
        return null;
    }
}

export default new Config();