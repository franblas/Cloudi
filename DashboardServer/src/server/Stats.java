package server;

import java.awt.Dimension;
import java.util.ArrayList;

import javax.swing.JEditorPane;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.PlotOrientation;
import org.jfree.data.category.DefaultCategoryDataset;

import com.mysql.jdbc.Connection;

import database.db;

/**
 * 
 * @author Paco
 *
 */
public class Stats {
	
	private Connection co = null;
	
	/**
	 * 
	 * @param co
	 */
	public Stats(Connection co) {
		this.co = co;
	}

	/**
	 * 
	 * @param nameuser
	 * @param namevm
	 */
	public void affichevminfo(String nameuser, String namevm){
		ArrayList<String> vminfos = new db().vminfo(nameuser,namevm,co);
		String icone = null;
		if(vminfos.get(2).equals("xppro") || vminfos.get(2).equals("xpfamilial")){
			icone="xp_logo";
		}
		else{
			icone=vminfos.get(2);
		}
		
		String toto = "";
		toto+="<html><body>";
		toto+="<img src='file:/var/www/images/"+icone+".png' width=90 height=90></img>";
		toto+="<span style='font-size:25px;'>"+vminfos.get(1)+"</span><br/>";
		toto+="<table><tr><td style='font-size:14px;'>ID  </td><td>"+vminfos.get(0)+"</td></tr> <br/>";
		toto+="<tr ><td style='font-size:14px;'>OS</td><td>"+vminfos.get(2)+"</td></tr> <br/>";
		toto+="<tr><td style='font-size:14px;'>RAM</td><td>"+vminfos.get(3)+" Mo</td></tr> <br/>";
		toto+="<tr><td style='font-size:14px;'>RAM video</td><td>"+vminfos.get(4)+" Mo</td></tr> <br/>";
		toto+="<tr><td style='font-size:14px;'>ROM</td><td>"+vminfos.get(5)+" Go</td></tr> <br/>";
		toto+="<tr><td style='font-size:14px;'>Utilisateur</td><td>"+vminfos.get(6)+"</td></tr> <br/>";
		toto+="<tr><td style='font-size:14px;'>Reseau</td><td>"+vminfos.get(7)+"</td></tr> <br/>";
		toto+="</table></body></html> <br/>";
		
		JEditorPane textarea = new JEditorPane("text/html",toto);//creation panneau affichage elements htnl
		JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
		scrollpane.setPreferredSize(new Dimension(400,300));
		JOptionPane.showMessageDialog(null,scrollpane,"VM - "+vminfos.get(1)+"",JOptionPane.INFORMATION_MESSAGE);		
	}

	/**
	 * 
	 */
	public void affichestats(){
		int appli = new db().applicationBDDList(co).size();
		int rss = new db().rssBDDcount(co);
		int user = new db().userBDDList(co).size();
		
		DefaultCategoryDataset dataset = new DefaultCategoryDataset();
		dataset.addValue(appli, "Applications", new Integer(1));
		dataset.addValue(user, "Utilisateurs", new Integer(1));
		dataset.addValue(rss, "Flux RSS", new Integer(1));
		
		JFreeChart barChart = ChartFactory.createBarChart("Statistiques","","Nombre", dataset,PlotOrientation.VERTICAL,true,true,false);
		ChartPanel cPanel = new ChartPanel(barChart);
		JPanel textarea = new JPanel();
		textarea.add(cPanel);
		JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
		scrollpane.setPreferredSize(new Dimension(500,500));
		JOptionPane.showMessageDialog(null,scrollpane,"Statistiques",JOptionPane.INFORMATION_MESSAGE);
	}

}//end of class
