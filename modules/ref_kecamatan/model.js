import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import KabKota from '../ref_kab_kota/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(6),
		primaryKey: true
	},
	kab_kota_id: {
		type: DataTypes.CHAR(6),
	},
	nama_kecamatan: {
		type: DataTypes.STRING
	},
	level_wilayah: {
		type: DataTypes.SMALLINT,
		defaultValue: 3
	}
}

let allias = "kc"

const Kecamatan = sq.define('ref_kecamatan',
	columns,
	{
		freezeTableName: true,
	    timestamps: true,
	    createdAt: 'created_at',
	    updatedAt: 'updated_at',
	    paranoid: true,
	    deletedAt: 'deleted_at',
	}
)

KabKota.hasMany(Kecamatan, { foreignKey: 'kab_kota_id' })
Kecamatan.belongsTo(KabKota, { foreignKey: 'kab_kota_id' })

export default Kecamatan