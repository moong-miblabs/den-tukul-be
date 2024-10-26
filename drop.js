import { env } from './env.js'
import pg from 'pg'
const { Client } = pg

let raw = `
	DROP TABLE IF EXISTS user_role;
	DROP TABLE IF EXISTS users;
	DROP TABLE IF EXISTS ms_role;

	DROP TABLE IF EXISTS ref_jenjang;
	DROP TABLE IF EXISTS ref_penghasilan;
	DROP TABLE IF EXISTS ref_pekerjaan;
	DROP TABLE IF EXISTS ref_agama;

	DROP TABLE IF EXISTS ref_kelurahan;
	DROP TABLE IF EXISTS ref_kecamatan;
	DROP TABLE IF EXISTS ref_kab_kota;
	DROP TABLE IF EXISTS ref_provinsi;
`

const client = new Client({
  user: env('DB_USERNAME'),
  password: env('DB_PASSWORD'),
  host: env('DB_HOST'),
  port: env('DB_PORT'),
  database: env('DB_DATABASE'),
})
await client.connect()

client.query(raw)
.then(([results]) => {
	console.log(results)
	console.log('Drop Berhasil')
	console.log('disconnecting...')
    process.exit(0)
})
.catch(err => {
	console.error(err)
	console.log('disconnecting...')
    process.exit(0)
})