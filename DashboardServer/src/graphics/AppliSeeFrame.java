package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.util.ArrayList;

import javax.swing.JEditorPane;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JScrollPane;

import utils.BashUtils;

import com.mysql.jdbc.Connection;

import database.db;

/**
 * 
 * @author Paco
 *
 */
public class AppliSeeFrame extends JFrame{

	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan4 = new JPanel();
	
	/**
	 * 
	 * @param nom
	 * @param largeur
	 * @param hauteur
	 */
	public AppliSeeFrame(String nom,int largeur, int hauteur, Connection conn, String passsudo){
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
				
		ArrayList<String> applilist = new db().applicationBDDList(conn);
		String toto = "<html><body><table>";
		for(int k=0;k<applilist.size();k++){
			if(checkInstalledAppli(applilist.get(k).trim(),passsudo)){
				toto += "<tr><td style='font-size:14px;'>"+applilist.get(k)+"</td><td style='color:green;'>Installed</td></tr>";
			}
			else{
				toto += "<tr><td style='font-size:14px;'>"+applilist.get(k)+"</td><td style='color:red;'>Not Installed</td></tr>";
			}
		}
		toto+="</table></body></html>";
		
		JEditorPane textarea = new JEditorPane("text/html",toto);
		JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
		scrollpane.setPreferredSize(new Dimension(500,300));
				
		pan4.add(scrollpane);
		pan.add(pan4);
				
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);

		this.setVisible(true);
	}
	
	/**
	 * 
	 * @param appliname
	 * @param pass
	 * @return
	 */
	public boolean checkInstalledAppli(String appliname,String pass){
		String test = new BashUtils().outputCommand("which "+appliname,pass);
		boolean res = false;
		if(!test.trim().equals("")){
			res = true;
		}
		else{
			res = false;
		}
		return res;
	} 

}//end of class
