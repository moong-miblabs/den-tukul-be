import { env } from './env.js'
import { Sequelize } from 'sequelize'

const sequelize = new Sequelize(env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'), {
	host: env('DB_HOST'),
	port: env('DB_PORT'),
	dialect: env('DB_DIALECT'),
	logging: false
});

// sequelize.authenticate()
// .then(() => {
// 	console.log('Connection has been established successfully.');
// })
// .catch(error => {
// 	console.error('Unable to connect to the database:', error);
// })

export default sequelize