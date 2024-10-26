import { DataTypes } from 'sequelize';
import sq from '../../database.js'

import Provinsi from '../ref_provinsi/model.js'

let columns = {
	id: {
		type: DataTypes.CHAR(6),
		primaryKey: true
	},
	provinsi_id: {
		type: DataTypes.CHAR(6),
	},
	nama_kab_kota: {
		type: DataTypes.STRING
	},
	level_wilayah: {
		type: DataTypes.SMALLINT,
		defaultValue: 2
	}
}

let allias = 'kk'

const KabKota = sq.define('ref_kab_kota',
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

Provinsi.hasMany(KabKota, { foreignKey: 'provinsi_id' })
KabKota.belongsTo(Provinsi, { foreignKey: 'provinsi_id' })

export default KabKota