import sq from './database.js'
import { fileURLToPath } from 'url';
import path from 'path';
import fs from 'fs';

try {
    const __dirname = path.dirname(fileURLToPath(import.meta.url))
    const normalize = fs.readdirSync(path.join(__dirname, "./modules"));
    
    for (let i = 0; i < normalize.length; i++) {
        if(fs.readdirSync(path.join(__dirname, "./modules/"+normalize[i])).includes('model.js')){
            await import(`./modules/${normalize[i]}/model.js`)
        }
    }
    
    await sq.sync({ alter: true });
    console.log('Finish !')
} catch (error) {
    console.log('error !')
    console.log(error)
} finally {
    process.exit(0);
}